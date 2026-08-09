@props(['title', 'value', 'icon'])

<div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/80 transition-all duration-300 hover:shadow-md dark:bg-slate-900 dark:ring-slate-800">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                {{ $title }}
            </p>

            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                {{ $value }}
            </p>
        </div>

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition-transform group-hover:scale-110 dark:bg-indigo-950/50 dark:text-indigo-400">
            <x-admin.icon :name="$icon" class="h-6 w-6" />
        </div>
    </div>
</div>