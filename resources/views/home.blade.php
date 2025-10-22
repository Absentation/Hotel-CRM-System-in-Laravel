<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
        }
        .media-card {
            background: rgba(255,255,255,0.9);
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        .media-card img,
        .media-card video {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<nav class="container-fluid">
    <ul>
        <li><strong>Five Hotel</strong></li>
    </ul>
    <ul>
        <li><a href="#gallery">Gallery</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="{{ route('admin.login') }}">Admin</a></li>
    </ul>
</nav>

<main class="container">
    <section>
        <header>
            <h1>Welcome to Five Hotel</h1>
        </header>
        <p>Experience our curated amenities, exquisite dining, and exceptional hospitality.</p>
    </section>

    <section id="gallery" style="margin-top:2rem;">
        <header>
            <h2>Hotel Media Gallery</h2>
            <p>Images and videos uploaded by our team showcase the atmosphere and services awaiting you.</p>
        </header>

        @if($media->isEmpty())
            <article role="alert">Gallery will be updated soon.</article>
        @else
            <div class="media-grid">
                @foreach($media as $item)
                    <article class="media-card">
                        @if($item->media_type === 'image')
                            <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}">
                        @else
                            <video controls preload="metadata">
                                <source src="{{ asset('storage/' . $item->file_path) }}">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                        <div style="padding:1rem;">
                            <h3>{{ $item->title ?? 'Media item' }}</h3>
                            @if($item->description)
                                <p>{{ $item->description }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section id="contact" style="margin-top:3rem;">
        <header>
            <h2>Contact Us</h2>
        </header>
        <p>Email: stay@fivehotel.example</p>
        <p>Phone: +1 (555) 123-4567</p>
    </section>
</main>
</body>
</html>
