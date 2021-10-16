<x-app-layout>
    <form action="{{ route('client.projects.store') }}" method="post">
        @csrf
        @include('client.projects._form')
    </form>
</x-app-layout>