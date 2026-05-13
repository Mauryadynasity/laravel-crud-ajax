<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">
    @yield('content')

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
function enableEdit(el) {
    let parent = el.closest('.field');

    let text = parent.querySelector('.text');
    let input = parent.querySelector('.edit-input');

    if (text) text.style.display = 'none';
    if (input) {
        input.style.display = 'block';
        input.focus();
    }
}

document.addEventListener("DOMContentLoaded", function () {

    window.addQualification = function () {
        let wrapper = document.getElementById('qualification-wrapper');
        let div = document.createElement('div');
        div.classList.add('mb-2');
        div.innerHTML = `<input class="form-control" type="text" name="qualifications[]" placeholder="Qualification">`;

        wrapper.appendChild(div);
    };

    window.addExperience = function () {
        let wrapper = document.getElementById('experience-wrapper');
        let div = document.createElement('div');
        div.classList.add('mb-2');
        div.innerHTML = `<input class="form-control" type="text" name="experiences[]" placeholder="Experience">`;

        wrapper.appendChild(div);
    };

});


function saveProfile() {

    let formData = new FormData();
    formData.append('full_name', $('[name="full_name"]').val());
    formData.append('dob', $('[name="dob"]').val());
    formData.append('age', $('[name="age"]').val());

    let fileInput = $('input[type="file"]')[0];
    if (fileInput && fileInput.files[0]) {
        formData.append('profile_image', fileInput.files[0]);
    }

    $('#qualifications input').each(function() {
        let val = $(this).val();
        if (val) {
            formData.append('qualifications[]', val);
        }
    });

    $('#experiences input').each(function() {
        let val = $(this).val();
        if (val) {
            formData.append('experiences[]', val);
        }
    });

    formData.append('permanent_line1', $('.permanent_line1').val());
    formData.append('permanent_line2', $('.permanent_line2').val());
    formData.append('permanent_city', $('.permanent_city').val());
    formData.append('permanent_state', $('.permanent_state').val());

    formData.append('current_line1', $('.current_line1').val());
    formData.append('current_line2', $('.current_line2').val());
    formData.append('current_city', $('.current_city').val());
    formData.append('current_state', $('.current_state').val());

    formData.append('_token', '{{ csrf_token() }}');

    // AJAX CALL
    $.ajax({
        url: '/profile/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            $('#success-msg').text('Profile Updated Successfully');
            $('.full_name_text').text($('[name="full_name"]').val());
            $('.dob_text').text($('[name="dob"]').val());
            $('.age_text').text($('[name="age"]').val());
            
            $('#qualifications .field').each(function() {
                let inputVal = $(this).find('input').val();
                $(this).find('.qualification_text').text(inputVal);
            });

            $('#experiences .field').each(function() {
                let inputVal = $(this).find('input').val();
                $(this).find('.experience_text').text(inputVal);
            });

            
            if (res.image) {
                $('#profile-img').attr('src', res.image + '?' + new Date().getTime());
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Error: All fields are Mandatory');
            return;
        }
    });
}

function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('preview-image');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<script src="{{ asset('js/min.js') }}"></script>
</body>
</html>