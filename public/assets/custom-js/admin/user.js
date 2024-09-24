const branch_id_choices_element = new Choices(document.querySelector('#branch_id'), {
    shouldSort: false,
    searchPlaceholderValue: select_branch,
    itemSelectText: '',
    maxItemCount: Infinity
});
$(document).on('change', '#region_id', function () {
    var region_id = $(this).val()
    branch_id_choices_element
    branch_id_choices_element.disable();
    branch_id_choices_element.clearStore();
    loaderView()
    axios
        .get(APP_URL + '/get-branch-by-region/' + region_id)
        .then(function (response) {
            var trips = response.data.branches;
            const choicesOptions = [
                {value: '', label: select_branch, selected: true, disabled: true}
            ];
            trips.forEach(function (value) {
                choicesOptions.push({
                    value: value.id,
                    label: value.name
                });
            });
            branch_id_choices_element.setChoices(choicesOptions, 'value', 'label', {sorting: false});
            branch_id_choices_element.enable();
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
})