<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Transfer Routes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="w-4/5 mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Material Transfer Request</h1>
            <div class="flex gap-2 items-center">
                <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-6">Select Transfer Route</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('material-transfer.show', 'mab-to-ahmadi') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-4 px-6 rounded-lg text-center transition duration-200">
                    MAB to Ahmadi
                </a>
                
                <a href="{{ route('material-transfer.show', 'ahmadi-to-mab') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white font-medium py-4 px-6 rounded-lg text-center transition duration-200">
                    Ahmadi to MAB
                </a>
                
                <a href="{{ route('material-transfer.show', 'mab-to-etd-ardhiya') }}" 
                   class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-4 px-6 rounded-lg text-center transition duration-200">
                    MAB to ETD Ardhiya
                </a>
                
                <a href="{{ route('material-transfer.show', 'etd-ardhiya-to-mab') }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-4 px-6 rounded-lg text-center transition duration-200">
                    ETD Ardhiya to MAB
                </a>
                
                <a href="{{ route('material-transfer.show', 'ahmadi-to-etd-ardhiya') }}" 
                   class="bg-red-500 hover:bg-red-600 text-white font-medium py-4 px-6 rounded-lg text-center transition duration-200">
                    Ahmadi to ETD Ardhiya
                </a>
                
                <a href="{{ route('material-transfer.show', 'etd-ardhiya-to-ahmadi') }}" 
                   class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-4 px-6 rounded-lg text-center transition duration-200">
                    ETD Ardhiya to Ahmadi
                </a>
            </div>
        </div>
    </div>
</body>
</html>