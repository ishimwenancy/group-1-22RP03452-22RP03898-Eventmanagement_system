<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
</head>
<body>
    <h1>Create Student</h1>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>


