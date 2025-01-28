@props(['fields' => [], 'rows' => []])
<x-nova-view::card>
    <div class="overflow-hidden overflow-x-auto relative">
        <table class="w-full divide-y divide-gray-100 dark:divide-gray-700" dusk="resource-table">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    @foreach ($fields as $field)
                    <th class="px-6 py-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide text-left">
                        <span>{{ $field }}</span>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach ($rows as $row)
                    <tr class="group">
                        @foreach ($row as $field)
                        <td class="px-6 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                            <div class="text-left">
                                {{ $field }}
                            </div>
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-nova-view::card>
