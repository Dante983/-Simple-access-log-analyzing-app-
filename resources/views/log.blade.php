<form action="/log" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="text" name="name">
    @csrf
    <button type="submit">Upload File</button>
</form>
