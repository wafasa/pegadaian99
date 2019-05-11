$("#basic-forms").steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "slideLeft",
    enableContentCache: true,
    autoFocus: true
});
$("#verticle-wizard").steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "slide",
    stepsOrientation: "vertical",
    autoFocus: true
});

$("#design-wizard").steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "slideLeft",
    autoFocus: true
});




var form = $("#example-advanced-form").show();

form.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffectSpeed: 600,
    transitionEffect: "slideLeft",
    onStepChanging: function(event, currentIndex, newIndex) {
        // var def = $.Deferred();

        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex) {
            return true;
        }

        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex) {

            // can show if all form not null
            if(form.valid()){
                $('#modal-akad-notif').modal('show')
            }

            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }

        $('#tidak').on('click', function(){
            form.steps("previous");
        });

        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function(event, currentIndex) {
        // console.log(currentIndex)
        $('#iya').on('click', function(){
            // window.location.href = url + '/cabang';
        });
        
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function(event, currentIndex) {
        // in file form-akad-js
        akad_confirm()
    }
}).validate({
    errorPlacement: function errorPlacement(error, element) {
        element.before(error);
    },
});