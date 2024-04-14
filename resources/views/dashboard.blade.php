<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

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


                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('json.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Json File Uploader</label>
                            <input type="file" name="json_file" class="form-control-file" id="">
                        </div>
                        <input type="submit" class="btn btn-sm btn-primary">
                    </form>
                </div>

                <div class="p-6 text-gray-900">

                    <table style="border: 1px solid black;">
                        <thead style="border: 1px solid black;">
                          <tr style="border: 1px solid black;">
                            <th scope="col">#</th>
                            <th scope="col">File Name</th>
                            <th scope="col">File</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody >
                            @foreach ($jsons as $key=>$json )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$json->file_name??''}}</td>
                                <td>{{$json->file_path??''}}</td>
                                <td><a href="{{route('json.download',$json->id)}}">Download</a></td>
                              </tr>
                            @endforeach


                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
