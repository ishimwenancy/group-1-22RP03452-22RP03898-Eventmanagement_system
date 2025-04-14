<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ $student->name }}" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $student->email }}" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="{{ $student->phone }}" required>
        <br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
