<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Candidate Registration</h2>

        <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
            <div class="mb-3">
                <label class="form-label">Full Name:</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control">

                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Birthday:</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
                @error('birth_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Avatar:</label>
                <input type="file" name="avatar_path" class="form-control">

                @error('avatar_path')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">CV (PDF):</label>
                <input type="file" name="cv_path" class="form-control">

                @error('cv_path')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Bio:</label>
                <textarea name="bio" class="form-control">{{ old('bio') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
                @include('components.alert')
    </div>
</body>

</html>
