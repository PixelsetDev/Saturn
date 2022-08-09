<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style type="text/tailwindcss">
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    @layer components {
        .btn {
            @apply px-4 py-2 rounded-sm appearance-none border transition duration-200 relative text-center dark:btn-dark btn-light;
        }
        .btn-sm {
            @apply btn px-2 py-1 text-sm;
        }
        .btn-dark {
            @apply bg-neutral-700 text-white border-neutral-900 hover:bg-neutral-600;
        }
        .btn-light {
            @apply bg-neutral-200 text-black border-neutral-400 hover:bg-neutral-100;
        }

        .input {
            @apply px-2 py-1 my-2 rounded-sm appearance-none border input-light dark:input-dark;
        }
        .input-full {
            @apply input w-full;
        }
        .input-dark {
            @apply bg-neutral-700 text-white border-neutral-900 placeholder:text-neutral-400;
        }
        .input-light {
            @apply bg-neutral-200 text-black border-neutral-400 placeholder:text-neutral-400;
        }
    }
</style>
