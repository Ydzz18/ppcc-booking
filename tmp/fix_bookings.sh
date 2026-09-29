#!/bin/sh
python3 - << 'EOF'
with open('/var/www/resources/views/bookings.blade.php', 'r') as f:
    content = f.read()

# Simple string replacement
old_str = '''<div class="relative order-first z-10 sm:col-start-1" x-on:click.outside="actionsOpen = false" :class="actionsOpen ? 'z-50' : 'z-10'">
                                                <div class="inline-flex rounded-md shadow-sm">
                                                    <button type="button" x-on:click="actionsOpen = !actionsOpen" :aria-expanded="actionsOpen.toString()" class="inline-flex min-h-9 w-32 items-center justify-between rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                        {{ __('Actions') }}
                                                           <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </div>
                                                <div x-show="actionsOpen" x-cloak class="absolute left-0 top-full z-50 mt-1 w-40 overflow-hidden rounded-md border border-gray-200 bg-white py-1 shadow-lg">
                                                    <a href="{{ route('bookings.print', $monitoring) }}" target="_blank" rel="noopener" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Print') }}</a>
                                                    @if ($allRequiredFormsCompleted)
                                                        <a href="{{ route('bookings.edit', ['monitoring' => $monitoring, 'show_submission_form' => 1]) }}" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm {{ $submissionStatus === 'completed' ? 'text-green-700 hover:bg-green-50' : 'text-blue-700 hover:bg-blue-50' }}">{{ $submissionStatus === 'completed' ? __('View Details') : __('Submission Process') }}</a>
                                                    @endif
                                                    @unless ($allRequiredFormsCompleted)
                                                        <a href="{{ route('bookings.edit', $monitoring) }}" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Update') }}</a>
                                                    @endunless
                                                    @if (Auth::user()->isAdmin())
                                                        <form method="POST" action="{{ route('bookings.destroy', $monitoring) }}" data-confirm="{{ __('Are you sure you want to delete this task monitoring entry?') }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">{{ __('Delete') }}</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>'''

new_str = '''<div class="order-first flex flex-wrap items-center gap-2">
                                                <a href="{{ route('bookings.edit', $monitoring) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-700">
                                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5.433 13.917l1.262-3.155A4 4 0 0113.58 9.42l6.92-6.92a2.001 2.001 0 00-2.83-2.83l-6.923 6.92a4 4 0 00-1.330 6.83l-3.996 3.996a1 1 0 00.17 1.41l2.583 2.583a1 1 0 001.41-.17z" /></svg>
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('bookings.print', $monitoring) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-green-700">
                                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V4zm3 1h4v2H8V5zm0 4h4v2H8V9zm0 4h4v2H8v-2z" clip-rule="evenodd" /></svg>
                                                    {{ __('Print') }}
                                                </a>
                                                <a href="{{ route('bookings.pdf', $monitoring) }}" class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700">
                                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                                    {{ __('PDF') }}
                                                </a>
                                                @if (Auth::user()->isAdmin())
                                                    <form method="POST" action="{{ route('bookings.destroy', $monitoring) }}" data-confirm="{{ __('Delete?') }}" class="inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-orange-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-orange-700">
                                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>'''

content = content.replace(old_str, new_str)

with open('/var/www/resources/views/bookings.blade.php', 'w') as f:
    f.write(content)

print("Done")
EOF
