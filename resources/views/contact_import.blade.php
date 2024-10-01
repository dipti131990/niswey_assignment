@include('header')
<div class="container mt-3">
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2>Upload XML File</h2>
    <form action="{{ route('import.xml') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 mt-3">
            <input type="file" name="xml_file" accept=".xml">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>

@include('footer')

