@extends('layouts.print', [
    'title' => __('Task Details'),
    'backUrl' => route('settings.index', ['tab' => 'tasks']),
    'downloadUrl' => route('tasks.pdf', $task),
])

@section('content')
    <header class="document-header">
        <h1>{{ __('Task Details') }}</h1>
        <p>{{ config('app.name', 'PPCC Booking') }}</p>
    </header>

    <section class="section">
        <h2>{{ __('Task Information') }}</h2>
        <dl class="details">
            <div class="detail">
                <dt>{{ __('Task ID') }}</dt>
                <dd>{{ $task->id }}</dd>
            </div>
            <div class="detail">
                <dt>{{ __('Task Name') }}</dt>
                <dd>{{ $task->task_name }}</dd>
            </div>
            <div class="detail">
                <dt>{{ __('Created') }}</dt>
                <dd>{{ $task->created_at?->format('F d, Y h:i A') ?? '—' }}</dd>
            </div>
        </dl>
    </section>
@endsection