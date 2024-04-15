{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


</x-app-layout> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assessment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>



    <div class="container mt-5">

        <div class="row">
            <div class="col-sm-12 p-3" style="background-color: rgb(201, 195, 195);display:flex">
                <p>Dashboard</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif
            <div class="col-sm-4">
                <form action="{{route('json.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="formFile" class="form-label">Json File Uploader</label>
                <input type="file" name="json_file" class="form-control" id="">
                <br>
                <input type="submit" class="btn btn-sm btn-success">
                </form>

            </div>
            <div class="col-sm-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th scope="col">File Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jsons as $key => $json)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $json->file_name ?? '' }}</td>
                                <td><a href="{{ route('json.download', $json->id) }}">Download</a></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="col-sm-4">

            </div>
        </div>
    </div>

</body>

</html>
