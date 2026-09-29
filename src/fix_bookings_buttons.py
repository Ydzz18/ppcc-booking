#!/usr/bin/env python3
import re

with open('/var/www/resources/views/bookings.blade.php', 'r') as f:
    lines = f.readlines()

# Find the line with "relative order-first"
for i, line in enumerate(lines):
    if 'relative order-first z-10 sm:col-start-1' in line:
        # Find the matching closing </div> for the actions section
        # It should be ~18 lines later
        start = i
        end = i + 18
        
        # Replace lines start to end with the new buttons
        new_buttons = '''                                            <div class="order-first flex flex-wrap items-center gap-2">
                                                <a href="{{ route('bookings.edit', $monitoring) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('bookings.print', $monitoring) }}" target="_blank" class="inline-flex items-center gap-1 rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white">
                                                    {{ __('Print') }}
                                                </a>
                                                <a href="{{ route('bookings.pdf', $monitoring) }}" class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white">
                                                    {{ __('PDF') }}
                                                </a>
                                                @if (Auth::user()->isAdmin())
                                                    <form method="POST" action="{{ route('bookings.destroy', $monitoring) }}" class="inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-orange-600 px-3 py-1.5 text-xs font-semibold text-white">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
'''
        
        lines = lines[:start] + [new_buttons] + lines[end:]
        break

with open('/var/www/resources/views/bookings.blade.php', 'w') as f:
    f.writelines(lines)

print("Done")
