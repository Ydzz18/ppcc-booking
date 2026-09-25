<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Workspace') }}</p>
                <h2 class="mt-1 text-xl font-semibold tracking-tight text-gray-900">{{ __('Notifications') }}</h2>
            </div>
            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                {{ trans_choice(':count open booking|:count open bookings', $notifications->total(), ['count' => $notifications->total()]) }}
            </span>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm" aria-labelledby="notifications-title">
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-4">
                <div>
                    <h3 id="notifications-title" class="text-lg font-semibold text-gray-900">{{ __('Action required') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Open bookings that still need completion or review.') }}</p>
                </div>
                <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">
                    {{ __('Task Monitoring') }}
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse ($notifications as $notification)
                    <a href="{{ route('bookings.edit', $notification) }}" class="flex items-center justify-between gap-4 py-5 transition hover:bg-gray-50">
                        <div class="min-w-0 border-l-2 border-amber-400 pl-4">
                            <p class="truncate text-sm font-semibold text-gray-900">
                                {{ $notification->task?->task_name ?? __('Booking') }}
                            </p>
                            <p class="mt-1 truncate text-sm text-gray-500">
                                {{ $notification->client?->client_name ?? __('Unknown client') }}
                            </p>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">
                                {{ ucfirst($notification->submission_status ?: 'pending') }}
                            </span>
                            <p class="mt-1 text-xs text-gray-400">{{ $notification->created_at?->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                    <div class="py-12 text-center">
                        <p class="text-sm font-medium text-gray-900">{{ __('You are all caught up.') }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ __('There are no open booking notifications.') }}</p>
                    </div>
                @endforelse
            </div>

            @if ($notifications->hasPages())
                <div class="border-t border-gray-100 pt-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
