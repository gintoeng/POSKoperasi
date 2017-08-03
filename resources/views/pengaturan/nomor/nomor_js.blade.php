<script>

    (function ($) {
        $.fn.toggleOption = function (value, show) {
            /// <summary>Show or hide the desired option</summary>
            return this.filter('select').each(function () {
                var select = $(this);
                if (typeof show === 'undefined') {
                    show = select.find('option[value="' + value + '"]').length == 0;
                }
                if (show) {
                    select.showOption(value);
                }
                else {
                    select.hideOption(value);
                }
            });
        };
        $.fn.showOption = function (value) {
            /// <summary>Show the desired option in the location it was in when hideOption was first used</summary>
            return this.filter('select').each(function () {
                var select = $(this);
                var found = select.find('option[value="' + value + '"]').length != 0;
                if (found) return; // already there

                var info = select.data('opt' + value);
                if (!info) return; // abort... hideOption has not been used yet

                var targetIndex = info.data('i');
                var options = select.find('option');
                var lastIndex = options.length - 1;
                if (lastIndex == -1) {
                    select.prepend(info);
                }
                else {
                    options.each(function (i, e) {
                        var opt = $(e);
                        if (opt.data('i') > targetIndex) {
                            opt.before(info);
                            return false;
                        }
                        else if (i == lastIndex) {
                            opt.after(info);
                            return false;
                        }
                    });
                }
                return;
            });
        };
        $.fn.hideOption = function (value) {
            /// <summary>Hide the desired option, but remember where it was to be able to put it back where it was</summary>
            return this.filter('select').each(function () {
                var select = $(this);
                var opt = select.find('option[value="' + value + '"]').eq(0);
                if (!opt.length) return;

                if (!select.data('optionsModified')) {
                    // remember the order
                    select.find('option').each(function (i, e) {
                        $(e).data('i', i);
                    });
                    select.data('optionsModified', true);
                }

                select.data('opt' + value, opt.detach());
                return;
            });
        };
    })(jQuery);

    function konfirm(id) {
        swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
        }).then(function() {
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
            location.href =  "{{ url('pengaturan/nomor') }}/" + id + "/destroy";
        })

    }

    $("#modul").removeAttr('class');
    $("#modul").select2();

    $("#spa").removeAttr('class');
    $("#spa").select2();
    $("#spa2").removeAttr('class');
    $("#spa2").select2();
    $("#spa3").removeAttr('class');
    $("#spa3").select2();

    $("#frmt").removeAttr('class');
    $("#frmt").select2();
    $("#frmt2").removeAttr('class');
    $("#frmt2").select2();
    $("#frmt3").removeAttr('class');
    $("#frmt3").select2();
    $("#frmt4").removeAttr('class');
    $("#frmt4").select2();

    $("#modul").on("change", function() {
        if($(this).val() == "POS") {
            $("#frmt").val("").change();
            $('#frmt').attr("disabled", false);
            $('#frmt').showOption('kdcab');
            $('#frmt2').showOption('kdcab');
            $('#frmt3').showOption('kdcab');
            $('#frmt4').showOption('kdcab');
        } else {
            if($(this).val() == "Master customer") {
                $("#frmt").val("digit").change();
                $('#frmt').attr("disabled", true);
            } else {
                $("#frmt").val("").change();
                $('#frmt').attr("disabled", false);
            }
            $('#frmt').hideOption('kdcab');
            $('#frmt2').hideOption('kdcab');
            $('#frmt3').hideOption('kdcab');
            $('#frmt4').hideOption('kdcab');
        }
    });

</script>
