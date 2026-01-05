<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movies AI Agent</title>
    <link rel="icon" type="image/png" href="/images/favicon.png">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-white text-slate-800 h-screen overflow-hidden flex flex-col">

<!-- Header -->
<header class="border-b border-slate-200 shrink-0">
    <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <img src="/images/logo.png" alt="Movies AI" style="height:38px;width:auto;" />
        </div>

        <a href="mailto:abstractador@gmail.com" class="rounded-lg border border-indigo-600 px-4 py-2 font-semibold text-indigo-600 hover:bg-indigo-50">
            Contact
        </a>
    </div>
</header>

<!-- Progress -->
<div id="aiProgressWrapper" class="shrink-0 hidden">
    <div class="mx-auto max-w-3xl px-6 py-4">
        <div class="h-3 w-full rounded-full bg-slate-200 overflow-hidden">
            <div
                id="aiProgressBar"
                class="h-full w-0 bg-indigo-600 text-xs text-white flex items-center justify-center font-semibold transition-all duration-300 ease-out"
            >
               
            </div>
        </div>
    </div>
</div>

<!-- Main  -->
<main class="flex-1 overflow-hidden mx-auto max-w-6xl px-6 py-4 w-full">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 h-full">

        <!-- Left: Benefits -->
        <aside class="lg:col-span-4 overflow-y-auto">
            <div class="space-y-6">

                <h2 class="text-lg font-semibold text-slate-700">
                    Why use Movies AI?
                </h2>

                <div class="space-y-4 text-left">
                    <div class="flex gap-3"><span class="text-green-500">✔</span> Personalized AI recommendations</div>
                    <div class="flex gap-3"><span class="text-green-500">✔</span> Semantic search</div>
                    <div class="flex gap-3"><span class="text-green-500">✔</span> Find movies fast</div>
                    <div class="flex gap-3"><span class="text-green-500">✔</span> AI + Pinecone vector search</div>
                    <div class="flex gap-3"><span class="text-green-500">✔</span> No signup required</div>
                </div>

            </div>
        </aside>

        <!-- Right: Chat -->
        <section class="lg:col-span-8 flex flex-col h-full overflow-hidden">

            <!-- Messages -->
            <div
                id="chatMessages"
                class="flex-1 overflow-y-auto space-y-6 pr-2 pb-6"
            >
                <div class="flex items-start gap-4">
                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold">
                        AI
                    </div>
                    <div class="bg-slate-100 rounded-2xl px-4 py-3 max-w-[80%]">
                        Hi 👋 I’m your Movies AI assistant.
                    </div>
                </div>
            </div>

            <!-- INPUT -->
            <form
                id="chatForm"
                class="shrink-0 border-t border-slate-200 bg-white p-4"
            >
                <div class="relative">
                    <textarea
                        id="chatInput"
                        rows="2"
                        placeholder="Message Movies AI…"
                        class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 pr-24 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    ></textarea>

                    <button
                        type="submit"
                        class="absolute bottom-2 right-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500"
                    >
                        Send
                    </button>
                </div>
            </form>

        </section>
    </div>

</main>

</body>
</html>
