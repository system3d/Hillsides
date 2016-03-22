$(function() {
    $(".show-permissions").click(function(e) {
        e.preventDefault();
        var $this = $(this);
        var role = $this.data('role');
        var permissions = $(".permission-list[data-role='"+role+"']");
        var hideText = $this.find('.hide-text');
        var showText = $this.find('.show-text');
        // console.log(permissions)

        ; // for debugging

        // show permission list
        permissions.toggleClass('hidden');

        // toggle the text Show/Hide for the link
        hideText.toggleClass('hidden');
        showText.toggleClass('hidden');
    });
    //Checks checkboxes for dependencies
    $("input[name='permission_user[]']").change(function() {
        checkDependencies($(this));
    });

    //Recursively check dependencies
    function checkDependencies(item) {
        var dependencies = item.data('dependencies');
        var count = 0;

        if (dependencies.length) {
            for (var i = 0; i < dependencies.length; i++) {
                if (item.is(":checked")) {
                    var permission = $("#permission-" + dependencies[i]);

                    if (! permission.is(":checked"))
                        permission.prop("checked", true);

                    count++;

                    if (count == 1)
                        checkDependencies(permission);
                }
            }
        }
    }
});
