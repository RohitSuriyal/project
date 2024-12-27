<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- Include jQuery -->
    <title>Hello, world!</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="d-flex justify-content-center mt-5">

        <div class="w-50 shadow-lg p-5">
            <h1>Update details</h1>
            <form method="post" action="{{route('formdatasubmitupdate')}}">
                @csrf

                <input type="hidden" name="hiddenid" value="{{$data[0]->id}}">
                <label>title</label>
                <input class="form-control" type="text" name="titleupdate" id="titleInput" value="{{$data[0]->title}}" oninput="validateTextInput(event)" required>

                <label>Description</label>
                <input type="text" name="descriptionupdate" value="{{$data[0]->description}}" class="form-control" required>
                <label>status</label>
                <select name="statusupdate" class="form-control" required>
                    <option value="completed" {{ $data[0]->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ $data[0]->status == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <label>Due Date</label>
                <input name="dateupdate" type="date" value="{{$data[0]->date}}" class="form-control" required>
                <button class="btn btn-success mt-3 w-50">Submit</button>
            </form>
        </div>
    </div>









    <script>
        function validateTextInput(event) {
            let value = event.target.value;
          
            event.target.value = value.replace(/[^a-zA-Z\s]/g, '');
        }
    </script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>