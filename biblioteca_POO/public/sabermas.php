<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Bienvenido a Biblioteca</title>
</head>

<body>
    <?php
        require '../vendor/autoload.php';
        require '../src/_cabecera.php'
    ?>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white"> Nuestra Colección</h1>
    <p class="mb-3 text-gray-500 dark:text-gray-400 first-letter:font-bold first-letter:text-gray-900 dark:first-letter:text-gray-100">En nuestra biblioteca, nos enorgullece ofrecer una vasta colección de materiales de lectura que abarcan diversos géneros y temas. Nuestro catálogo incluye:</p>
    <br>
    <br>
    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400 ml-4">
        <li>
            Literatura Clásica y Contemporánea: Desde las obras maestras atemporales hasta las novelas modernas que están dando de qué hablar.
        </li>
        <li>
            Ciencia y Tecnología: Mantente al día con los últimos avances y descubrimientos.
        </li>
        <li>
            Historia y Cultura: Explora el pasado y descubre diferentes culturas.
        </li>
        <li>
            Desarrollo Personal y Profesional: Amplía tus horizontes y habilidades con una selección cuidadosa de libros que fomentan el crecimiento personal y profesional.
        </li>
    </ul>
    <br>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Plataforma Interactiva
    </h1>
    <p class="mb-3 text-gray-500 dark:text-gray-400 first-letter:font-bold first-letter:text-gray-900 dark:first-letter:text-gray-100">
        Nuestra biblioteca digital va más allá de ser solo un repositorio de libros. Ofrecemos una plataforma interactiva donde puedes:

        Reseñar y Calificar Libros: Comparte tus opiniones sobre las lecturas que has disfrutado.
        Participar en Discusiones: Únete a discusiones enriquecedoras sobre tus libros y autores favoritos.
        Recomendar Nuevas Adquisiciones: Sugiere nuevos títulos para expandir nuestra colección y enriquecer la comunidad.
    </p>
    <br>
    <br>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Comunidad Apasionada
    </h1>
    <p class="mb-3 text-gray-500 dark:text-gray-400 first-letter:font-bold first-letter:text-gray-900 dark:first-letter:text-gray-100">
        Únete a una comunidad de lectores apasionados que valoran el conocimiento, la discusión abierta y el amor por la lectura. Aquí, encontrarás amigos con los que podrás compartir tu pasión por los libros y la literatura.
    </p>
    <br>
    <br>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Únete a Nosotros
    </h1>
    <p class="mb-3 text-gray-500 dark:text-gray-400 first-letter:font-bold first-letter:text-gray-900 dark:first-letter:text-gray-100">
        Embárcate en una travesía de conocimiento y descubrimiento. Regístrate hoy y comienza a explorar todo lo que nuestra biblioteca digital tiene para ofrecer. Tu espacio de lectura te espera con páginas llenas de aventuras, aprendizaje y camaradería.
    </p>



    <figure class="max-w-screen-md mx-auto text-center">
        <svg class="w-10 h-10 mx-auto mb-3 text-gray-400 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 14">
            <path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z" />
        </svg>
        <blockquote>
            <p class="text-2xl italic font-medium text-gray-900 dark:text-white">Para más información, no dudes en contactarnos a través de nuestra página de contacto o a nuestro correo electrónico: info@tuespaciodelectura.com. Estamos aquí para ayudarte en tu viaje literario. ¡Bienvenido a tu nuevo hogar de lectura digital!</p>
        </blockquote>
        <figcaption class="flex items-center justify-center mt-6 space-x-3">
            <img class="w-6 h-6 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gouch.png" alt="profile picture">
            <div class="flex items-center divide-x-2 divide-gray-500 dark:divide-gray-700">
                <cite class="pr-3 font-medium text-gray-900 dark:text-white">Micheal Gough</cite>
                <cite class="pl-3 text-sm text-gray-500 dark:text-gray-400">CEO at Biblioteca</cite>
            </div>
        </figcaption>
    </figure>


    <?php require '../src/_footer.php' ?>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>
