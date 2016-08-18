function uploadPicture(){
    showPreloader();
    var file = this.files[0];
    var form = new FormData();
    form.append($(this).attr('name'), file);
    var self = this;

    $.ajax({
        url: uploadUrl,
        type: 'POST',
        contentType: false,
        processData: false,
        data: form,
        success: function(response){
            var result = JSON.parse(response);
            hidePreloader();
            if(result.error){
                showError(result.error, 'Ошибка загрузки файла');
                $('#uploadPictureInput').val('');
            }else{
                hideError();
                hideSuccess();
                showPreview(result.file);
                $('.alert-info').hide();
                $('#uploadPictureInput').val('');
            }
        }
    });
}
function removePicture(){
    showPreloader();
    var picture = $(this).parent();
    var path = $(this).data('path');
    $.ajax({
        url: removeUrl,
        type: 'POST',
        data: 'path='+path,
        success: function(response){
            var result = JSON.parse(response);
            hidePreloader();
            if(result.error){
                showError('Не удалось удалить изображение '+ result.error, 'Ошибка');
            }else{
                hideError();
                hideSuccess();
                showSuccess(result.success,'Удача');
                removePathFromInput(path);
                picture.remove();

                if(picture.parent().children().length == 0){
                    $('.alert-info').show();
                }
            }
        }
    });

}

function showSuccess(success, title) {
    container.append('<div class="alert alert-success"><strong>'+title+'! </strong>'+success+'</div>');
}
function showError(error, title){
    container.append('<div class="alert alert-danger"><strong>'+title+'! </strong>'+error+'</div>');
}

function hideSuccess(){
    container.find('.alert-success').remove();
}
function hideError(){
    container.find('.alert-danger').remove();
}
function showPreloader(){
    $('#preloader').show();
}

function hidePreloader(){
    $('#preloader').hide();
}

function showPreview(obj){
    var pictureUrl = obj.storageUrl+obj.path;
    addPathToInput(obj.path);
    container.append('<div class="previewBox"><div class="img-wrap"><img src="'+pictureUrl+'"></div><button type="button" class="btn btn-danger removePicture" data-path="'+obj.path+'"><span class="glyphicon glyphicon-remove"></span></button></div>');
    $('.removePicture').bind('click', removePicture);
}

function addPathToInput(path){
    var input = $('#'+targetInputId);
    var pictures = ($('#'+targetInputId).val() != '') ? JSON.parse(input.val()) : [];
    if(pictures.length < maxPictureCount){
        pictures.push(path);
    }
    if(pictures.length == maxPictureCount){
        $('#uploadPictureInput').attr('disabled', 'disabled');
    }

    input.val(JSON.stringify(pictures));
}

function removePathFromInput(path){
    var input = $('#'+targetInputId);
    var pictures = ($('#'+targetInputId).val() != '') ? JSON.parse(input.val()) : [];
    for(var i = 0; i < pictures.length; i++){
        if(pictures[i] == path){
            pictures.splice(i, 1);
        }
    }
    if(pictures.length < maxPictureCount){
        $('#uploadPictureInput').removeAttr('disabled');
    }
    if(pictures.length == 0){
        input.val('');
    }else{
        input.val(JSON.stringify(pictures));
    }

}
var container = $('#pictures-wrapper');
$('#uploadPictureInput').bind('change', uploadPicture);
$('.removePicture').bind('click', removePicture);
var pictures = $('#uploadPictureInput').val();


