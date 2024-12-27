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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add a record
    </button>
    <div class="d-flex justify-content-end">
        <a href="{{route('logout')}}" class="btn btn-primary">Logout</a>

    </div>
    <div>
        <form id="formstatusfilter">
            @csrf
            <select id="statusfilter" name="statusfilter" class="form-control w-25 my-5">
                <option>Sort by status</option>
                <option value="completed">completed</option>
                <option value="pending">Pending</option>
            </select>
        </form>
        <form id="formdatefilter">
            @csrf
            <select id="datefilter" name="datefilter" class="form-control w-25 my-5">
                <option>Sort by Date</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </form>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('formdatasubmit')}}">
                        @csrf
                        <label>title</label>
                        <input class="form-control" type="text" name="title" id="titleInput" oninput="validateTextInput(event)" required>

                        <label>Description</label>
                        <input type="text" name="description" class="form-control" required>
                        <label>status</label>
                        <select type="text" name="status" class="form-control" required>
                            <option value="completed">
                                Completed
                            </option>
                            <option class="pending">Pending</option>
                        </select>
                        <label>Due Date</label>
                        <input name="date" type="date" class="form-control" required>
                        <button class="btn btn-success mt-3 w-50">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <table class="table" id="tabledata">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">description</th>
                <th scope="col">status</th>
                <th scope="col">date</th>
                <th scope="col">update</th>
                <th scope="col">delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <th scope="row">{{$row->id}}</th>
                <td>{{$row->title}}</td>
                <td>{{$row->description}}</td>
                <td>{{$row->status}}</td>
                <td>{{$row->date}}</td>
                <td><a class="btn btn-success" href="{{route('updatedata',['id'=>$row->id])}}">Update</a></td>
                <td><a class="btn btn-danger" href="{{route('deletedata',['id'=>$row->id])}}">Delete</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>





    <script>
        $("#statusfilter").on("change", function() {

            var formData = $('#formstatusfilter').serialize();

          
            $.ajax({
                url: "{{route('filterstatus')}}", 
                type: 'post', 
                data: formData,
                success: function(response) {
                    const updateUrl = "{{ route('updatedata', ['id' => '__id__']) }}";
                    const deleteUrl = "{{ route('deletedata', ['id' => '__id__']) }}";
                    if (response.status == "success") {
                        const data = response.data;

                        
                        $("#tabledata").empty();

                     
                        let rows = "";
                        data.forEach(function(row) {
                           
                            let updateLink = updateUrl.replace('__id__', row.id);
                            let deleteLink = deleteUrl.replace('__id__', row.id);

                            rows += `
        <tr>
            <th scope="row">${row.id}</th>
            <td>${row.title}</td>
            <td>${row.description}</td>
            <td>${row.status}</td>
            <td>${row.date}</td>
            <td><a class="btn btn-success" href="${updateLink}">Update</a></td>
            <td><a class="btn btn-danger" href="${deleteLink}">Delete</a></td>
        </tr>
        `;
                        });

                        
                        $("#tabledata").append(`
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">Date</th>
            <th scope="col">Update</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        ${rows}
    </tbody>
    `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });



        $("#datefilter").on("change", function() {

            var formData = $('#formdatefilter').serialize();
=
            $.ajax({
                url: "{{route('filterdate')}}", 
                type: 'post', 
                data: formData,
                success: function(response) {
                    const updateUrl = "{{ route('updatedata', ['id' => '__id__']) }}";
                    const deleteUrl = "{{ route('deletedata', ['id' => '__id__']) }}";
                    if (response.status == "success") {
                        const data = response.data;

                        
                        $("#tabledata").empty();

                        
                        let rows = "";
                        data.forEach(function(row) {
                          
                            let updateLink = updateUrl.replace('__id__', row.id);
                            let deleteLink = deleteUrl.replace('__id__', row.id);

                            rows += `
        <tr>
            <th scope="row">${row.id}</th>
            <td>${row.title}</td>
            <td>${row.description}</td>
            <td>${row.status}</td>
            <td>${row.date}</td>
            <td><a class="btn btn-success" href="${updateLink}">Update</a></td>
            <td><a class="btn btn-danger" href="${deleteLink}">Delete</a></td>
        </tr>
        `;
                        });

                       
                        $("#tabledata").append(`
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">Date</th>
            <th scope="col">Update</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        ${rows}
    </tbody>
    `);
                    }


                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });





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
    @if(session('successupdate'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('successupdate') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if(session('successupdatenochange'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('successupdatenochange') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if(session('delete'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('delete') }}",
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