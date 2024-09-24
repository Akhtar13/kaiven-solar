<?php

namespace App\Console\Commands;

use App\Helpers\SystemFileHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class GenerateFilesFromDatabase extends Command
{
    protected $signature = 'app:generate-files-from-database';
    protected $description = 'Generate Laravel files from database tables';

    protected array $messages = [
        'app_name' => 'Laravel Project',
        'dashboard' => 'Dashboard',
        'select' => 'Select',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'add_new' => 'Add New',
        'id' => 'Id',
        'action' => 'Action',
        'profile' => 'Profile',
        'change_password' => 'Change Password',
        'current_password ' => 'Current Password',
        'new_password' => 'New Password',
        'confirm_password' => 'Confirm Password',
        'update_profile' => 'Update Profile',
        'logout' => 'Logout',
        'email' => 'Email',
        'password' => 'Password',
        'enter_email' => 'Enter Email',
        'enter_password' => 'Enter Password',
        'forgot_password' => 'Forgot Password?',
        'sign_in' => 'Sign In',
        'confirm_button_text' => 'Yes',
        'cancel_button_text' => 'No'
    ];

    public function handle(): void
    {
        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.mysql.database');
        $tableList = [];
        foreach ($tables as $table) {
            $tableList[] = $table->{"Tables_in_{$databaseName}"};
        }

        $selectedTables = $this->choice('Select tables to generate files for', $tableList, null, null, true);

        // Generate files for the selected tables
        foreach ($selectedTables as $table) {
            $viewPath = resource_path('views/admin/' . SystemFileHelper::getViewName($table) . '/create.blade.php');
            if (file_exists($viewPath)) {
                $this->info(SystemFileHelper::getViewName($table) . ' File IS already created so you can just update code.');
            } else {
                $this->generateFiles($table);
            }
        }

        $this->info('Files generated successfully.');
    }

    protected function getViewName($value)
    {
        return strtolower(str_replace('_', '-', $value));
    }

    protected function generateFiles($table)
    {
        // Generate Model
        SystemFileHelper::generateModel($table);

        // Generate Controller
        SystemFileHelper::generateController($table);

        // Generate Views
        SystemFileHelper::generateCreateView($table);
        SystemFileHelper::generateEditView($table);
        SystemFileHelper::generateIndexView($table);

        // Generate Request File with Validation Rules
        SystemFileHelper::generateRequestFile($table);

        // Generate Routes
        SystemFileHelper::generateRoutes($table);

        // Generate sidebar items
        SystemFileHelper::generateSidebarItems($table);

        //print_r($this->messages);
    }

    protected function generateModel($table): bool
    {
        $modelName = $this->getClassName($table);
        $modelPath = app_path("Models/{$modelName}.php");

        $modelTemplate = "<?php


    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class {$modelName} extends Model
    {
        use HasFactory;
        protected \$table = '{$table}';
    }";

        $modelFolderPath = app_path('Models/');
        if (!File::exists($modelFolderPath)) {
            File::makeDirectory($modelFolderPath, 0755, true);
        }
        File::put($modelPath, $modelTemplate);
        return true;
    }

    protected function getClassName($value)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));
    }

    protected function generateController($table)
    {
        $controllerName = $this->getClassName($table) . 'Controller';
        $modelName = $this->getClassName($table);
        $controllerPath = app_path("Http/Controllers/Admin/{$controllerName}.php");

        // Get column names excluding 'id'
        $columns = Schema::getColumnListing($table);
        $columns = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
        });

        // Check for foreign keys
        $foreignKeys = DB::select("
    SELECT
        COLUMN_NAME,
        REFERENCED_TABLE_NAME,
        REFERENCED_COLUMN_NAME
    FROM
        information_schema.KEY_COLUMN_USAGE
    WHERE
        TABLE_NAME = '{$table}'
        AND TABLE_SCHEMA = DATABASE()  -- Ensure it queries only the current database
        AND REFERENCED_TABLE_NAME IS NOT NULL
");


        // Check for foreign keys
        $enumColumns = DB::select("
            SELECT
                COLUMN_NAME
            FROM
                information_schema.COLUMNS
            WHERE
                TABLE_NAME = '{$table}'
        AND TABLE_SCHEMA = DATABASE()  -- Ensure you are querying the correct database
        AND DATA_TYPE = 'enum'
        ");

        // Prepare foreign key data for use in the controller
        $foreignKeyData = [];
        $selectColumns = ["'{$table}.id'"];
        $joinClauses = '';
        foreach ($foreignKeys as $foreignKey) {
            $foreignKeyData[$foreignKey->COLUMN_NAME] = $foreignKey->REFERENCED_TABLE_NAME;
            $selectColumns[] = "'{$foreignKey->REFERENCED_TABLE_NAME}.name as {$foreignKey->COLUMN_NAME}_name'";
            $joinClauses .= "->leftJoin('{$foreignKey->REFERENCED_TABLE_NAME}', '{$table}.{$foreignKey->COLUMN_NAME}', '=', '{$foreignKey->REFERENCED_TABLE_NAME}.id')";
        }

        // Create a string with the column names for use in select statements and validation
        foreach ($columns as $column) {
            if (!isset($foreignKeyData[$column])) {
                $selectColumns[] = "'{$table}.{$column}'";
            }
        }

        // Create a string with the column names for use in select statements and validation
        $selectColumnsString = implode(', ', $selectColumns);

        $controllerTemplate = "<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Helpers\AdminDataTableButtonHelper;
    use App\Http\Requests\Admin\\{$modelName}Request;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Yajra\DataTables\Facades\DataTables;
    use App\Models\\{$modelName};
    use Illuminate\Support\Carbon;

    class {$controllerName} extends Controller
    {
        public function index()
        {
            return view('admin." . $this->getViewName($table) . ".index');
        }

        public function getDatatable(Request \$request)
        {
            if (\$request->ajax()) {
                \$data = {$modelName}::select({$selectColumnsString})
                    {$joinClauses}
                    ->where('{$table}.deleted_at', null);
                return DataTables::of(\$data)
                    ->addColumn('action', function (\$row) {
                        \$array = [
                            'id' => \$row->id,
                            'actions' => [
                                'edit' => route('admin." . $this->getViewName($table) . ".edit', [\$row->id]),
                                'delete' => '',
                            ]
                        ];
                        return AdminDataTableButtonHelper::actionButtonDropdown2(\$array);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        public function create()
        {
            {$this->generateForeignKeyAssignments($foreignKeyData)}
            {$this->generateEnumAssignments($table, $enumColumns)}
            return view('admin." . $this->getViewName($table) . ".create', [" . $this->generateViewParameters($foreignKeyData, $enumColumns) . "]);
        }

        public function store({$modelName}Request \$request): JsonResponse
        {
            \$details = \$request->only(['{$this->generateColumnString($columns)}']);
            if ((int)\$request['edit_value'] === 0) {
                \$model = new {$modelName}();
                foreach (\$details as \$key => \$value) {
                    \$model->\$key = \$value;
                }
                \$model->save();

                return response()->json([
                    'success' => true, 'message' => trans('messages." . strtolower($table) . "_added_successfully')
                ]);
            }
            \$model = {$modelName}::find(\$request['edit_value']);
            foreach (\$details as \$key => \$value) {
                \$model->\$key = \$value;
            }
            \$model->save();

            return response()->json([
                'success' => true, 'message' => trans('messages." . strtolower($table) . "_updated_successfully')
            ]);
        }

        public function edit(\$id)
        {
            \$model = {$modelName}::findOrFail(\$id);
            {$this->generateForeignKeyAssignments($foreignKeyData)}
            {$this->generateEnumAssignments($table,$enumColumns)}
            return view('admin." . $this->getViewName($table) . ".edit', [
                '" . strtolower($table) . "' => \$model,
                " . $this->generateViewParameters($foreignKeyData, $enumColumns) . "
            ]);
        }

        public function destroy(\$id): JsonResponse
        {
            {$modelName}::where('id', \$id)->update(['deleted_at' => Carbon::now()]);
            return response()->json(['message' => trans('messages." . strtolower($table) . "_deleted_successfully')]);
        }}";

        // Write the controller class to the appropriate path

        $this->addTranslationKey(strtolower($table) . "_added_successfully", $this->getLabel($table) . " added successfully.");
        $this->addTranslationKey(strtolower($table) . "_updated_successfully", $this->getLabel($table) . " updated successfully.");
        $this->addTranslationKey(strtolower($table) . "_deleted_successfully", $this->getLabel($table) . " deleted successfully.");

        File::put($controllerPath, $controllerTemplate);
    }

    protected function generateForeignKeyAssignments($foreignKeyData)
    {
        $assignments = '';
        foreach ($foreignKeyData as $column => $referencedTable) {
            $assignments .= "\$" . strtolower($referencedTable) . "s = \\App\\Models\\Admin\\" . $this->getClassName($referencedTable) . "::where('deleted_at', null)->get();\n";
        }
        return $assignments;
    }

    protected function generateEnumAssignments($table, $enumColumns)
    {
        $assignments = '';
        foreach ($enumColumns as $column) {
            dump($column->COLUMN_NAME, $table);
            $columnDetails = DB::select("SHOW COLUMNS FROM `{$table}` LIKE '{$column->COLUMN_NAME}'");
            $enumOptions = $columnDetails[0]->Type;
            preg_match('/^enum\((.*)\)$/', $enumOptions, $matches);
            $enumValues = explode(',', $matches[1]);
            $assignments .= "$" . strtolower($column->COLUMN_NAME) . "_options = [";
            foreach ($enumValues as $value) {
                $assignments .= "'" . trim($value, "'") . "', ";
            }
            $assignments = rtrim($assignments, ', ') . "];\n";
        }
        return $assignments;
    }

    protected function generateViewParameters($foreignKeyData, $enumColumns)
    {
        $parameters = [];
        foreach ($foreignKeyData as $column => $referencedTable) {
            $parameters[] = "'" . strtolower($referencedTable) . "s' => $" . strtolower($referencedTable) . "s";
        }

        foreach ($enumColumns as $column) {
            $parameters[] = "'" . strtolower($column->COLUMN_NAME) . "_options' => $" . strtolower($column->COLUMN_NAME) . "_options";
        }
        return implode(', ', $parameters);
    }

    protected function generateColumnString($columns)
    {
        return implode("', '", $columns);
    }

    protected function addTranslationKey($key, $value)
    {
        $filePath = resource_path('lang/en/messages.php');

        // Load existing translations
        if (file_exists($filePath)) {
            $this->messages = include $filePath;
        } else {
            $this->messages = []; // If the file doesn't exist, initialize an empty array
        }

        // Check if the key already exists
        if (!array_key_exists($key, $this->messages)) {
            // Add the new key and value
            $this->messages[$key] = $value;

            // Generate the PHP code for the updated translations array
            $exportedArray = var_export($this->messages, true);

            // Prepare the content to be written back to the file
            $content = "<?php\n\nreturn {$exportedArray};\n";

            // Save the updated array back to the messages.php file
            file_put_contents($filePath, $content);

            // echo "Translation key '{$key}' added successfully.\n";
        } else {
            // echo "Translation key '{$key}' already exists.\n";
        }
    }

    protected function getLabel($value)
    {
        return ucwords(str_replace('_', ' ', $value));
    }

    protected function generateCreateView($table)
    {
        $viewPath = resource_path('views/admin/' . $this->getViewName($table) . '/create.blade.php');
        $columns = Schema::getColumnListing($table);
        $columns = array_filter($columns, static function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
        });

        $formFields = '';
        foreach ($columns as $column) {
            // Fetch the foreign key details for the specified column
            $foreignKey = DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('TABLE_NAME', $table)
                ->where('COLUMN_NAME', $column)
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensure it's the current database
                ->whereNotNull('REFERENCED_TABLE_NAME')
                ->select('COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
                ->first();

// Check if the column is required (i.e., not nullable)
            $isNullable = DB::table('information_schema.COLUMNS')
                    ->where('TABLE_NAME', $table)
                    ->where('COLUMN_NAME', $column)
                    ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensure it's the current database
                    ->value('IS_NULLABLE') === 'NO';

            $requiredAttribute = $isNullable ? ' required' : '';


            // Check the data type of a specific column
            $dataType = DB::table('information_schema.COLUMNS')
                ->where('TABLE_NAME', $table)
                ->where('COLUMN_NAME', $column)
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensure it queries the current database
                ->value('DATA_TYPE');

            if ($foreignKey) {
                $referencedTable = $foreignKey->REFERENCED_TABLE_NAME;
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <select class=\"form-select\" data-choices name=\"{$column}\" id=\"{$column}\" data-choices name=\"choices-single-default\">
                                        <option value=\"\">{{ trans('messages.select') }}</option>
                                        @if(!is_null($" . strtolower($referencedTable) . "s))
                                            @foreach($" . strtolower($referencedTable) . "s as $" . strtolower($referencedTable) . ")
                                                <option value=\"{{\$" . strtolower($referencedTable) . "->id}}\">{{\$" . strtolower($referencedTable) . "->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>\n";


            } elseif ($dataType === 'enum') {
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <select class=\"form-select\" data-choices name=\"{$column}\" id=\"{$column}\">
                                        <option value=\"\">{{ trans('messages.select') }}</option>
                                        @foreach(\${$column}_options as \$option)
                                            <option value=\"{{ \$option }}\">{{ \$option }}</option>
                                        @endforeach
                                    </select>
                                </div>\n";
            } elseif ($dataType === 'text' || $dataType === 'longtext') {
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <textarea class=\"form-control\" id=\"{$column}\" name=\"{$column}\" rows=\"4\"
                                              placeholder=\"{{trans('messages.{$column}')}}\"></textarea>
                                </div>\n";
            } else {
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <input type=\"text\" class=\"form-control\" id=\"{$column}\" name=\"{$column}\"
                                        placeholder=\"{{trans('messages.{$column}')}}\" autofocus>
                                </div>\n";


            }

            $this->addTranslationKey($column, $this->getLabel($column));
        }

        $this->addTranslationKey(strtolower($table), $this->getLabel($table));
        $this->addTranslationKey(strtolower($table) . "_add", "Add " . $this->getLabel($table));


        $createViewTemplate = "@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class=\"row\">
            <div class=\"col-12\">
                <div class=\"page-title-box d-sm-flex align-items-center justify-content-between\">
                    <h4 class=\"mb-sm-0\">{{trans('messages." . strtolower($table) . "')}}</h4>
                </div>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"card\">
                    <div class=\"card-header\">
                        <h5 class=\"card-title mb-0\">{{trans('messages." . strtolower($table) . "_add')}}</h5>
                    </div>

                    <div class=\"card-body\">
                        <form method=\"POST\" data-parsley-validate=\"\" id=\"addEditForm\" role=\"form\">
                            @csrf
                            <input type=\"hidden\" id=\"edit_value\" value=\"0\" name=\"edit_value\">

                            <div class=\"row\">
                                {$formFields}

                                <div class=\"text-end\">
                                    <button type=\"submit\" class=\"btn btn-success btn-sm\">{{trans('messages.save')}}</button>
                                    <a href=\"{{ route('admin." . $this->getViewName($table) . ".index') }}\"
                                    class=\"btn btn-danger btn-sm\">{{trans('messages.cancel')}}</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('custom-script')
        <script>
            let form_url = '/" . $this->getViewName($table) . "';
            let redirect_url = '/" . $this->getViewName($table) . "';
        </script>
        <script src=\"{{ asset('assets/custom-js/custom/form.js') }}?v={{time()}}\"></script>
        <script>
        </script>
    @endsection";

        // Write the create view file to the appropriate path

        $viewFolderPath = resource_path('views/admin/' . $this->getViewName($table));
        if (!File::exists($viewFolderPath)) {
            File::makeDirectory($viewFolderPath, 0755, true);
        }


        File::put($viewPath, $createViewTemplate);
    }

    protected function generateEditView($table)
    {
        $viewPath = resource_path('views/admin/' . $this->getViewName($table) . '/edit.blade.php');
        $columns = Schema::getColumnListing($table);
        $columns = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
        });

        $formFields = '';
        foreach ($columns as $column) {
            // Check if the column is a foreign key
            // Fetch the foreign key details for the specified column
            $foreignKey = DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('TABLE_NAME', $table)
                ->where('COLUMN_NAME', $column)
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensure it's the current database
                ->whereNotNull('REFERENCED_TABLE_NAME')
                ->select('COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
                ->first();

// Check if the column is required (i.e., not nullable)
            $isNullable = DB::table('information_schema.COLUMNS')
                    ->where('TABLE_NAME', $table)
                    ->where('COLUMN_NAME', $column)
                    ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensure it's the current database
                    ->value('IS_NULLABLE') === 'NO';

            $requiredAttribute = $isNullable ? ' required' : '';

            // Check the data type of a specific column
            $dataType = DB::table('information_schema.COLUMNS')
                ->where('TABLE_NAME', $table)
                ->where('COLUMN_NAME', $column)
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensure it queries the current database
                ->value('DATA_TYPE');


            if ($foreignKey) {
                $referencedTable = $foreignKey->REFERENCED_TABLE_NAME;
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <select class=\"form-select\" data-choices name=\"{$column}\" id=\"{$column}\"  data-choices name=\"choices-single-default\" >
                                        <option value=\"\">{{ trans('messages.select') }}</option>
                                        @if(!is_null($" . strtolower($referencedTable) . "s))
                                            @foreach($" . strtolower($referencedTable) . "s as $" . strtolower($referencedTable) . ")
                                                <option value=\"{{\$" . strtolower($referencedTable) . "->id}}\" {{ $" . strtolower($table) . "->{$column} == $" . strtolower($referencedTable) . "->id ? 'selected' : '' }}>{{\$" . strtolower($referencedTable) . "->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>\n";
            } elseif ($dataType === 'enum') {
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <select class=\"form-select \" data-choices name=\"{$column}\" id=\"{$column}\">
                                        <option value=\"\">{{ trans('messages.select') }}</option>
                                        @foreach(\${$column}_options as \$option)
                                            <option value=\"{{ \$option }}\" {{ $" . strtolower($table) . "->{$column} == \$option ? 'selected' : '' }}>{{ \$option }}</option>
                                        @endforeach
                                    </select>
                                </div>\n";
            } elseif ($dataType === 'text' || $dataType === 'longtext') {
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <textarea class=\"form-control\" id=\"{$column}\" name=\"{$column}\" rows=\"4\"
                                            placeholder=\"{{trans('messages.{$column}')}}\">{{ $" . strtolower($table) . "->{$column} }}</textarea>
                                </div>\n";
            } else {
                $formFields .= "
                                <div class=\"col-lg-12 mb-3\">
                                    <label for=\"{$column}\" class=\"form-label{$requiredAttribute}\">{{trans('messages.{$column}')}}</label>
                                    <input type=\"text\" class=\"form-control\" id=\"{$column}\" name=\"{$column}\"
                                        value=\"{{ $" . strtolower($table) . "->{$column} }}\"
                                        placeholder=\"{{trans('messages.{$column}')}}\"autofocus>
                                </div>\n";
            }
        }

        $this->addTranslationKey(strtolower($table) . "_edit", "Edit " . $this->getLabel($table));

        $editViewTemplate = "@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class=\"row\">
            <div class=\"col-12\">
                <div class=\"page-title-box d-sm-flex align-items-center justify-content-between\">
                    <h4 class=\"mb-sm-0\">{{trans('messages." . strtolower($table) . "')}}</h4>
                </div>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"card\">
                    <div class=\"card-header\">
                        <h5 class=\"card-title mb-0\">{{trans('messages." . strtolower($table) . "_edit')}}</h5>
                    </div>

                    <div class=\"card-body\">
                        <form method=\"POST\" data-parsley-validate=\"\" id=\"addEditForm\" role=\"form\">
                            @csrf
                            <input type=\"hidden\" id=\"edit_value\" value=\"{{ $" . strtolower($table) . "->id }}\" name=\"edit_value\">

                            <div class=\"row\">
                                {$formFields}

                                <div class=\"text-end\">
                                    <button type=\"submit\" class=\"btn btn-success btn-sm\">{{trans('messages.save')}}</button>
                                    <a href=\"{{ route('admin." . $this->getViewName($table) . ".index') }}\"
                                    class=\"btn btn-danger btn-sm\">{{trans('messages.cancel')}}</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('custom-script')
        <script>
            let form_url = '/" . $this->getViewName($table) . "';
            let redirect_url = '/" . $this->getViewName($table) . "';
        </script>
        <script src=\"{{ asset('assets/custom-js/custom/form.js') }}?v={{time()}}\"></script>
    @endsection";

        // Write the edit view file to the appropriate path

        $viewFolderPath = resource_path('views/admin/' . $this->getViewName($table));
        if (!File::exists($viewFolderPath)) {
            File::makeDirectory($viewFolderPath, 0755, true);
        }

        File::put($viewPath, $editViewTemplate);
    }

    protected function generateIndexView($table)
    {
        $viewPath = resource_path('views/admin/' . $this->getViewName($table) . '/index.blade.php');
        $allColumns = Schema::getColumnListing($table);

        $excludedColumns = ['created_at', 'updated_at', 'deleted_at'];
        $columns = array_filter($allColumns, static function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        // Check for foreign keys
        $foreignKeys = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_NAME', $table)
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))  // Ensures it queries the current database
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->select('COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
            ->get();

        $columnHeaders = '';
        $datatableColumns = '';
        $foreignKeyData = [];

        foreach ($columns as $column) {
            if ($column !== 'id') {
                // Check if the column is a foreign key
                $foreignKey = $foreignKeys->firstWhere('COLUMN_NAME', $column);
                if ($foreignKey) {
                    $referencedTable = $foreignKey->REFERENCED_TABLE_NAME;
                    $foreignKeyData[$column] = $referencedTable;
                    $columnHeaders .= "<th>{{trans('messages.{$referencedTable}')}}</th>\n";
                    $datatableColumns .= "{data: '{$column}_name', name: '{$referencedTable}.name'},\n";

                    $this->addTranslationKey($referencedTable, $this->getLabel($referencedTable));
                } else {
                    $columnHeaders .= "<th>{{trans('messages.{$column}')}}</th>\n";
                    $datatableColumns .= "{data: '{$column}', name: '{$table}.{$column}'},\n";
                }
            }
        }


        $this->addTranslationKey(strtolower($table) . "_list", $this->getLabel($table) . " List");
        $this->addTranslationKey(strtolower($table) . "s", $this->getLabel($table) . "s");

        $indexViewTemplate = "@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class=\"row\">
            <div class=\"col-12\">
                <div class=\"page-title-box d-sm-flex align-items-center justify-content-between\">
                    <h4 class=\"mb-sm-0\">{{trans('messages." . strtolower($table) . "s')}}</h4>
                </div>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"card\">
                    <div class=\"card-header align-items-center d-flex\">
                        <h5 class=\"card-title mb-0 flex-grow-1\">{{trans('messages." . strtolower($table) . "_list')}}</h5>
                        <div class=\"flex-shrink-0\">
                            <div class=\"form-check form-switch form-switch-right form-switch-md\">
                                <a href=\"{{ route('admin." . $this->getViewName($table) . ".create') }}\"
                                class=\"btn btn-primary btn-sm\">{{trans('messages.add_new')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class=\"card-body\">
                        <table class=\"table table-bordered dt-responsive nowrap table-striped align-middle\"
                            id=\"basic-1\" style=\"width:100%\">
                            <thead>
                            <tr>
                                <th>{{trans('messages.id')}}</th>
                                {$columnHeaders}
                                <th>{{trans('messages.action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('custom-script')

        <script>
            let datatable_url = '/get-" . $this->getViewName($table) . "'
            let redirect_url = '/" . $this->getViewName($table) . "'
            let form_url = '/" . $this->getViewName($table) . "'
            const sweetalert_delete_title = '{{trans('messages." . strtolower($table) . "_delete_title')}}'
            const sweetalert_delete_text = '{{trans('messages." . strtolower($table) . "_delete_text')}}'

            $.extend(true, $.fn.dataTable.defaults, {
                columns: [
                    {data: 'id', name: '{$table}.id'},
                    {$datatableColumns}
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [0, 'desc']
            })
        </script>
        <script src=\"{{ asset('assets/custom-js/custom/datatable.js') }}?v={{time()}}\"></script>
    @endsection";

        // Write the index view file to the appropriate path

        $this->addTranslationKey(strtolower($table) . "_delete_title", $this->getLabel($table) . " Delete?");
        $this->addTranslationKey(strtolower($table) . "_delete_text", "Are You Sure Delete This " . $this->getLabel($table) . '?');

        $viewFolderPath = resource_path('views/admin/' . $this->getViewName($table));
        if (!File::exists($viewFolderPath)) {
            File::makeDirectory($viewFolderPath, 0755, true);
        }
        File::put($viewPath, $indexViewTemplate);
    }

    protected function generateRequestFile($table)
    {
        $columns = Schema::getColumnListing($table);
        $rules = [];

        foreach ($columns as $column) {

            if ($column != 'id') { //skip id column for request validation
                $query = "SHOW COLUMNS FROM $table WHERE Field = '$column'";

                //$columnDetails = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"));
                $columnDetails = DB::select($query);

                // Print the column details to debug
                //dd($columnDetails);

                $isNullable = $columnDetails[0]->Null === 'YES';

                if (!$isNullable) {
                    $rules[$column] = 'required';
                }
            }
        }


        $requestClassContent = "<?php

namespace App\Http\Requests\\Admin;

use Illuminate\Foundation\Http\FormRequest;

class " . $this->getClassName($table) . "Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return " . var_export($rules, true) . ";
    }
}";

        $requestFolderPath = app_path('Http/Requests/Admin/');
        if (!File::exists($requestFolderPath)) {
            File::makeDirectory($requestFolderPath, 0755, true);
        }

        $requestPath = app_path('Http/Requests/Admin/' . $this->getClassName($table) . 'Request.php');
        File::put($requestPath, $requestClassContent);
    }

    protected function generateRoutes($table)
    {
        $routePath = base_path('routes/admin.php');
        $controllerName = $this->getClassName($table) . 'Controller';

        $routes = "\nuse App\Http\Controllers\Admin\\{$controllerName};\n";
        $routes .= "Route::resource('{$this->getViewName($table)}', {$controllerName}::class);\n";
        $routes .= "Route::get('/get-{$this->getViewName($table)}', [{$controllerName}::class, 'getDatatable'])->name('get-{$table}');\n";

        File::append($routePath, $routes);
    }

    protected function generateSidebarItems($table)
    {
        echo "Copy below items for sidebar.\n\n<!--$table-->\n";
        echo "<li class=\"nav-item\">
                    <a class=\"nav-link menu-link {{ (request()->segment(2) === '" . $this->getViewName($table) . "') ? 'active' : '' }}\"
                       href=\"{{ route('admin." . $this->getViewName($table) . ".index') }}\" role=\"button\">
                        <i class=\"ri-dashboard-2-line\"></i> <span
                            data-key=\"t-dashboards\">{{trans('messages." . strtolower($table) . "')}}</span>
                    </a>
                </li>";
    }
}
