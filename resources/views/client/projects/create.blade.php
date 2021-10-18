<x-app-layout>
    <form action="{{ route('client.projects.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('client.projects._form')
    </form>
</x-app-layout>