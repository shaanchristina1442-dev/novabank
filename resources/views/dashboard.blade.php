
@extends('layouts.app') 

 

@section('content') 

 

<div class="container mx-auto px-6 py-8"> 

 

    <h1 class="text-3xl font-bold mb-6">NovaBank Dashboard</h1> 

 

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> 

 

        <!-- Total Balance Card --> 

        <div class="bg-white shadow-lg rounded-2xl p-6"> 

            <h2 class="text-gray-500 text-sm uppercase">Total Balance</h2> 

            <p class="text-3xl font-bold text-green-600 mt-2">$12,450.00</p> 

        </div> 

 

        <!-- Accounts Card --> 

        <div class="bg-white shadow-lg rounded-2xl p-6"> 

            <h2 class="text-gray-500 text-sm uppercase">Accounts</h2> 

            <p class="text-3xl font-bold mt-2">2</p> 

        </div> 

 

        <!-- Transactions Card --> 

        <div class="bg-white shadow-lg rounded-2xl p-6"> 

            <h2 class="text-gray-500 text-sm uppercase">Recent Transactions</h2> 

            <p class="text-3xl font-bold mt-2">5</p> 

        </div> 

 

    </div> 

 

    <!-- Recent Activity Section --> 

    <div class="mt-10 bg-white shadow-lg rounded-2xl p-6"> 

        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2> 

 

        <ul class="space-y-3"> 

            <li class="flex justify-between border-b pb-2"> 

                <span>Starbucks</span> 

                <span class="text-red-500">- $12.45</span> 

            </li> 

            <li class="flex justify-between border-b pb-2"> 

                <span>Paycheck Deposit</span> 

                <span class="text-green-600">+ $2,000.00</span> 

            </li> 

            <li class="flex justify-between border-b pb-2"> 

                <span>Amazon</span> 

                <span class="text-red-500">- $54.99</span> 

            </li> 

        </ul> 

    </div> 

 

</div> 

 

@endsection 
