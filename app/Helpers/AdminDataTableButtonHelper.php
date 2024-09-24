<?php

namespace App\Helpers;

class AdminDataTableButtonHelper
{
    public static function actionButtonDropdown($array): string
    {
        $action_button_dropdown = '<div class="btn-group" role="group" aria-label="Basic example">';
        foreach ($array['actions'] as $key => $value) {
            if ((string) $key === 'edit') {
                $action_button_dropdown .= '<a class="action-btn btn btn-primary" href="'.$value.'" >Edit</a>';
            } else {
                if ((string) $key === 'view') {
                    $action_button_dropdown .= '<a href="javascript:void(0)" class="action-btn btn btn-info btn-sm detail-button" data-id="'.$value.'">View</a>';
                } else {
                    if ((string) $key === 'view_page') {
                        $action_button_dropdown .= '<a href="'.$value.'" class="action-btn btn btn-success btn-sm">View</a>';
                    } else {
                        if ((string) $key === 'orderBy_button') {
                            $action_button_dropdown .= '<a href="'.$value.'" class="action-btn btn btn-success btn-sm">Item Order By</a>';
                        } else {
                            if ((string) $key === 'status' && (string) $value === 'active') {
                                $action_button_dropdown .= '<a href="javascript:void(0)"  data-status="inActive" data-id="'.$array['id'].'" class="action-btn btn btn-danger btn-sm status-change">Deactivate</a>';
                            } else {
                                if ((string) $key === 'status' && (string) $value === 'inActive') {
                                    $action_button_dropdown .= '<a href="javascript:void(0)" data-status="active" data-id="'.$array['id'].'" class="action-btn btn btn-success btn-sm status-change">Active</a>';
                                } else {
                                    if ((string) $key === 'status' && (int) $value === 1) {
                                        $action_button_dropdown .= '<a href="javascript:void(0)"  data-status="0" data-id="'.$array['id'].'" class="action-btn btn btn-danger btn-sm status-change">Deactivate</a>';
                                    } else {
                                        if ((string) $key === 'status' && (int) $value === 0 && (string) $value !== 'expired') {
                                            $action_button_dropdown .= '<a href="javascript:void(0)" data-status="1" data-id="'.$array['id'].'" class="action-btn btn btn-success btn-sm status-change">Active</a>';
                                        } else {
                                            if ((string) $key === 'delete') {
                                                $action_button_dropdown .= '<a href="javascript:void(0)"   data-id="'.$array['id'].'" class="action-btn btn btn-danger  delete-single">Delete</a>';
                                            } else {
                                                if ((string) $key === 'invoice') {
                                                    $action_button_dropdown .= '<a href="javascript:void(0)"   data-id="'.$array['id'].'" class="action-btn btn btn-danger download-invoice">Download</a>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $action_button_dropdown .= '</div>';

        return $action_button_dropdown;
    }

    public static function actionButtonDropdown2($array): string
    {
        $action_button_dropdown = '<div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">';
        foreach ($array['actions'] as $key => $value) {
            if ((string) $key === 'edit') {
                $action_button_dropdown .= '<li><a class="dropdown-item edit-item-btn" href="'.$value.'" ><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>';
            } elseif ((string) $key === 'view') {
                $action_button_dropdown .= '<li><a href="javascript:void(0)" class="dropdown-item detail-button" data-id="'.$value.'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>';
            } elseif ((string) $key === 'delete') {
                $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item remove-item-btn delete-single"> <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>';
            } elseif ((string) $key === 'invoice') {
                $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item download-invoice"> <i class="ri-file-download-line align-bottom me-2 text-muted"></i>Download</a></li>';
            } elseif ((string) $key === 'print') {
                $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item print-report"> <i class="ri-printer-line align-bottom me-2 text-muted"></i>Print</a></li>';
            } elseif ((string) $key === 'add_credit') {
                $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item add_credit"> <i class="ri-printer-line align-bottom me-2 text-muted"></i>Add Cradit</a></li>';
            }
        }
        $action_button_dropdown .= '</ul></div>';

        return $action_button_dropdown;

        //        $action_button_dropdown = '<div class="hstack gap-2">';
        //        foreach ($array['actions'] as $key => $value) {
        //            if ((string) $key === 'edit') {
        //                $action_button_dropdown .= '<a type="button" class="btn btn-outline-primary btn-border btn-icon waves-effect waves-light material-shadow-none" href="'.$value.'"><i class="bx bx-edit"></i></a>';
        //            } else {
        //                if ((string) $key === 'view') {
        //                    $action_button_dropdown .= '<li><a href="javascript:void(0)" class="dropdown-item detail-button" data-id="'.$value.'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>';
        //                } else {
        //                    if ((string) $key === 'delete') {
        //                        $action_button_dropdown .= '<button type="button" class="btn btn-outline-danger btn-border btn-icon waves-effect waves-light material-shadow-none delete-single"  data-id="'.$array['id'].'"><i class=" bx bx-trash"></i></button> ';
        //                    } else {
        //                        if ((string) $key === 'invoice') {
        //                            $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item download-invoice"> <i class="ri-file-download-line align-bottom me-2 text-muted"></i>Download</a></li>';
        //                        } else {
        //                            if ((string) $key === 'print') {
        //                                $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item print-report"> <i class="ri-printer-line align-bottom me-2 text-muted"></i>Print</a></li>';
        //                            } else {
        //                                if ((string) $key === 'add_credit') {
        //                                    $action_button_dropdown .= '<li><a href="javascript:void(0)"   data-id="'.$array['id'].'" class="dropdown-item add_credit"> <i class="ri-printer-line align-bottom me-2 text-muted"></i>Add Cradit</a></li>';
        //                                }
        //                            }
        //                        }
        //                    }
        //                }
        //            }
        //        }
        //        $action_button_dropdown.="</div>";
        //        return $action_button_dropdown;
        //
        //        $action_button_dropdown = '<ul class="list-inline hstack gap-2 mb-0">';
        //        foreach ($array['actions'] as $key => $value) {
        //            if ((string) $key === 'edit') {
        //                $action_button_dropdown .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">';
        //                $action_button_dropdown .= '<a href="'.$value.'" class="text-primary d-inline-block">';
        //                $action_button_dropdown .= '<i class="ri-pencil-fill fs-16"></i>';
        //                $action_button_dropdown .= '</a>';
        //                $action_button_dropdown .= '</li>';
        //            }
        //            if ((string) $key === 'view') {
        //                $action_button_dropdown .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="View" data-bs-original-title="View">';
        //                $action_button_dropdown .= '<a href="javascript:void(0)" class="text-primary d-inline-block  detail-button" data-id="'.$value.'">';
        //                $action_button_dropdown .= '<i class="ri-eye-fill fs-16"></i>';
        //                $action_button_dropdown .= '</a>';
        //                $action_button_dropdown .= '</li>';
        //            }
        //
        //            if ((string) $key === 'delete') {
        //                $action_button_dropdown .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">';
        //                $action_button_dropdown .= '<a href="javascript:void(0)" class="text-danger d-inline-block delete-single" data-id="'.$array['id'].'">';
        //                $action_button_dropdown .= '<i class="ri-delete-bin-5-fill fs-16"></i>';
        //                $action_button_dropdown .= '</a>';
        //                $action_button_dropdown .= '</li>';
        //            }
        //        }
        //        $action_button_dropdown .= '</ul>';
        //        return $action_button_dropdown;
    }

    public static function editButton($array): string
    {
        return '<button data-href="'.$array['route'].'"
             class="edit-button btn btn-primary  '.trans('themes_setting.button_style').'"
             data-toggle="tooltip"
             data-placement="top"
             title="'.trans('admin_string.common_edit').'">
             <i class="fa fa-pencil-square align-middle"></i>
             </button>';
    }

    public static function showRedirectButton($array): string
    {
        return '<button data-href="'.$array['show_route'].'"
             class="edit-button btn btn-success  '.trans('themes_setting.button_style').'"
             data-toggle="tooltip"
             data-placement="top"
             title="'.trans('admin_string.view').'">
             <i class="fa fa-eye align-middle"></i>
             </button>';
    }

    public static function detailButton($array): string
    {
        return '<button data-id="'.$array['id'].'"
             class="detail-button btn btn-sm btn-info"
             data-toggle="tooltip"
             data-placement="top"
             title="'.trans('messages.common_view').'">
             <i class="ri-eye-fill align-bottom"></i>
             </button>';
    }

    public static function deleteButton($array): string
    {
        return '<button data-id="'.$array['id'].'"
            class="delete-single btn btn-danger '.trans('themes_setting.button_style').'"
            data-toggle="tooltip"
            data-placement="top"
            title="'.trans('admin_string.common_delete').'">
            <i class="fa fa-trash align-middle"></i>
            </button>';
    }

    public static function activeInactiveStatusButton($array): string
    {
        if ((string) $array['status'] === 'active') {
            return '<button data-id="'.$array['id'].'"
            data-status="inActive" class="status-change btn btn-warning  '.trans('themes_setting.button_style').'"
            data-effect="effect-fall" data-toggle="tooltip"
            data-placement="top" title="'.trans('admin_string.common_status_inActive').'" >
            <i class="fa fa-refresh font-size-16 align-middle"></i></button>';
        }

        return '<button data-id="'.$array['id'].'"
        data-status="active" class="status-change btn btn-success btn-icon"
        data-effect="effect-fall" data-toggle="tooltip"
        data-placement="top" title="'.trans('admin_string.common_status_active').'" >
        <i class="fa fa-refresh  align-middle"></i></button>';
    }

    public static function statusBadge($array): string
    {
        if ((string) $array['status'] === 'active') {
            return '<div class="badge badge-success">'.trans('vendor_string.common_status_active').'</div>';
        }

        if ((string) $array['status'] === 'expired') {
            return '<div class="badge badge-warning">'.trans('vendor_string.common_status_expire').'</div>';
        }

        return '<div class="badge badge-danger">'.trans('vendor_string.common_status_inActive').'</div>';
    }

    public static function promoStatusBadge($array): string
    {
        if ($array['end_date'] < date('Y-m-d')) {
            return '<div class="badge badge-danger">Expired</div>';
        } else {
            if ((int) $array['status'] === 1) {
                return '<div class="badge badge-success">Active</div>';
            } else {
                if ((int) $array['status'] === 0) {
                    return '<div class="badge badge-warning">InActive</div>';
                }
            }
        }
    }

    public static function serviceStatusBadge($service): string
    {
        if ((int) $service->is_cancel === 1) {
            return '<div class="badge badge-danger">Cancelled</div>';
        } else {
            if ((int) $service->status === 2) {
                return '<div class="badge badge-primary">Completed</div>';
            } else {
                if ((int) $service->status === 1) {
                    return '<div class="badge badge-success">Booked</div>';
                } else {
                    return '<div class="badge badge-warning">Pending</div>';
                }
            }
        }
    }

    public static function serviceStatus($service): string
    {
        if ((int) $service->is_cancel === 1) {
            return 'Cancelled';
        } else {
            if ((int) $service->status === 2) {
                return 'Completed';
            } else {
                if ((int) $service->status === 1) {
                    return 'Booked';
                } else {
                    return 'Pending';
                }
            }
        }
    }
}
