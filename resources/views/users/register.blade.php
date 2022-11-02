<x-layout>

    <div class="form-signin w-100 m-auto text-center">
        <form id="registerForm" method="POST" action="#">
            @csrf
            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">
                {{ substr(url()->current(), -16) == 'manage/users/add' ? 'Please add a user' : 'Please Sign Up' }}</h1>

            <div class="form-floating">
                <input id="name" type="text" class="form-control" name="name">
                <label for="floatingInput">Name</label>

            </div>

            <div class="form-floating">
                <input id="email" type="email" class="form-control" name="email">
                <label for="floatingInput">Email address</label>


            </div>

            <div class="form-floating">
                <input id="password" type="password" class="form-control" name="password">
                <label for="floatingPassword">Password</label>

            </div>

            <div class="form-floating">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                <label for="floatingPassword">Confirm Password</label>
            </div>

            <div class="mt-8">
                <p>
                    Have an account?
                    <a href="/login" class="text-laravel">Login</a>
                </p>
            </div>
            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black" type="submit">Sign up</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $("#registerForm").validate({
            rules: {
                name: 'required',
                email: 'required',
                password: {
                    'required': true,
                    minlength: 6,
                },
                password_confirmation: {
                    minlength: 6,
                    equalTo: "#password"
                }

            },
            messages: {
                "password_confirmation": {
                    equalTo: 'Passwords do not match',
                    required: 'This field is required',
                    minlength: 'Passwords too short',

                }


            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
            },
            submitHandler: function() {
                register();
            }
        });

    });

    function register() {
        var fd = new FormData();

        fd.append('name', $('#name').val());
        fd.append('email', $('#email').val());
        fd.append('password', $('#password').val());
        fd.append('password_confirmation', $('#password_confirmation').val());
        fd.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: "/users",
            type: "POST",
            processData: false,
            contentType: false,
            data: fd,
            success: function(response) {
                location.href = "{{ url('/') }}";
            },
            error: function(err) {
                alert(err.responseJSON.message);
            }
        });
    }
</script>
