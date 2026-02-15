<x-app-layout>
    <div class="py-12 bg-[#050810] min-h-screen text-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- SECTION 1: USER MANAGEMENT -->
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg border border-gray-800 p-6">
                <h2 class="text-2xl font-bold text-white mb-6">User Management</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-800 text-sm">
                                <th class="py-3 px-4">User</th>
                                <th class="py-3 px-4">Location</th>
                                <th class="py-3 px-4">Plan</th>
                                <th class="py-3 px-4">Joined</th>
                                <th class="py-3 px-4">Admin Notes</th>
                                <th class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($users as $user)
                            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-medium text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($user->ip_address)
                                        <span class="bg-blue-900/30 text-blue-400 px-2 py-1 rounded text-xs">
                                            {{ $user->country ?? 'Unknown' }}
                                        </span>
                                        <div class="text-xs text-gray-600 mt-1">{{ $user->ip_address }}</div>
                                    @else
                                        <span class="text-gray-600">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($user->subscribed('default'))
                                        <span class="text-green-400 font-bold">PRO</span>
                                    @elseif($user->onTrial())
                                        <span class="text-yellow-400">Trial</span>
                                    @else
                                        <span class="text-gray-500">Free</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <form action="{{ route('admin.users.note', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td class="py-3 px-4">
                                        <textarea name="admin_notes" class="w-full bg-gray-800 border-none rounded text-xs text-gray-300 focus:ring-1 focus:ring-blue-500" rows="1" placeholder="Add note...">{{ $user->admin_notes }}</textarea>
                                    </td>
                                    <td class="py-3 px-4">
                                        <button type="submit" class="text-blue-400 hover:text-blue-300 text-xs">Save</button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- SECTION 2: CHANGELOG CMS -->
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg border border-gray-800 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">App Updates (Changelog)</h2>
                </div>

                <!-- Create Form -->
                <form action="{{ route('admin.changelog.store') }}" method="POST" class="space-y-4 mb-8 bg-gray-950 p-4 rounded border border-gray-800">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Update Title (e.g. 'New AI Features')" class="bg-gray-900 border border-gray-800 rounded text-white px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                        <input type="text" name="version" placeholder="Version (e.g. v1.2.0)" class="bg-gray-900 border border-gray-800 rounded text-white px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <textarea name="body" rows="4" placeholder="Description of changes (Markdown supported)..." class="bg-gray-900 border border-gray-800 rounded text-white px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500"></textarea>
                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2 text-sm text-gray-400">
                            <input type="checkbox" name="published" value="1" checked class="rounded border-gray-700 bg-gray-900 text-blue-600 shadow-sm focus:ring-offset-gray-900">
                            <span>Publish Immediately</span>
                        </label>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded shadow-lg transition">
                            Post Update
                        </button>
                    </div>
                </form>

                <!-- List of Updates -->
                <div class="space-y-4">
                    @foreach($changelogs as $log)
                        <div class="flex justify-between items-start border-b border-gray-800 pb-4 last:border-0">
                            <div>
                                <h3 class="font-bold text-white text-lg">{{ $log->title }} <span class="text-xs text-gray-500 bg-gray-800 px-1 rounded ml-2">{{ $log->version }}</span></h3>
                                <p class="text-sm text-gray-400 mt-1 line-clamp-2">{{ $log->body }}</p>
                                <div class="text-xs text-gray-600 mt-2">
                                    {{ $log->published_at ? 'Published: ' . $log->published_at->format('M d, Y') : 'Draft' }}
                                </div>
                            </div>
                            <form action="{{ route('admin.changelog.delete', $log) }}" method="POST" onsubmit="return confirm('Delete this update?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 text-xs">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
