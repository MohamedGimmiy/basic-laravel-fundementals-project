<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            hI.. <b> {{Auth::user()->name}} </b>
            <b style="float: right;">Total Users
            <span class="alert alert-danger">{{count($users)}}</span>
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">SL NO</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                          <th scope="row">{{$loop->index+1}}</th>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</x-app-layout>
