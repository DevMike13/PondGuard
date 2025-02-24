<div>
    <div class="w-full flex justify-end items-center mb-3">
        <x-button icon="plus-sm" primary label="Create New Sampling" onclick="$openModal('newSampling')" />
    </div>
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div>
                    @if (count($samplingLists) == 0)
                        <h1 class="text-center font-normal text-lg mt-5 italic text-gray-500">No data available.</h1>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Sampling No.</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Cycle No.</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Date</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Average Weight</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($samplingLists as $sampling)
                                    <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100 dark:odd:bg-neutral-800 dark:even:bg-neutral-700 dark:hover:bg-neutral-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                            <p class="text-lg font-semibold w-fit px-2.5 text-gray-500">{{$sampling->sampling_no}}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                            <p class="text-lg font-semibold w-fit px-2.5 text-yellow-500">{{$sampling->cycle_no}}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                            {{\Carbon\Carbon::parse($sampling->date)->format('M j, Y')}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                            {{ number_format($sampling->average_weight) }} Kg
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-4">
                                            <a class="flex items-center gap-x-1 py-2 rounded-lg text-sm text-blue-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700" href="#" onclick="$openModal('editSampling')" wire:click="getSelectedSampling({{ $sampling->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                    
                                                Edit
                                            </a>
                            
                                            <a class="flex items-center gap-x-1 py-2 rounded-lg text-sm text-red-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700" href="#" wire:click="deleteSamplingConfirmation({{$sampling->id}}, {{ $sampling->sampling_no }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>                                                                  
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-modal blur name="newSampling" persistent align="center" max-width="sm">
        <x-card title="Create New Sampling">
            
            <div>
                <x-inputs.number label="Sampling No." wire:model="samplingNo" />
            </div>

            <div class="mt-3">
                <x-inputs.number label="Cycle No." wire:model="cycleNo" />
            </div>
           
            <div class="mt-3">
                <x-datetime-picker
                    label="Date"
                    placeholder="Date"
                    parse-format="YYYY-MM-DD"
                    display-format="MMMM DD, YYYY"
                    wire:model.defer="samplingDate"
                    without-tips
                    :min="now()"
                    without-time
                />
            </div>

            <div class="mt-3">
                <x-inputs.number label="Average Weight" wire:model="averageWeight" />
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" wire:click="cancelCreate" />
                    <x-button primary label="Save" wire:click="createNewSampling" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <x-modal blur name="editSampling" persistent align="center" max-width="sm">
        <x-card title="Edit Sampling">
            
            <div>
                <x-inputs.number label="Sampling No." wire:model="editSamplingNo" />
            </div>

            <div class="mt-3">
                <x-inputs.number label="Cycle No." wire:model="editCycleNo" />
            </div>
           
            <div class="mt-3">
                <x-datetime-picker
                    label="Date"
                    placeholder="Date"
                    parse-format="YYYY-MM-DD"
                    display-format="MMMM DD, YYYY"
                    wire:model.defer="editSamplingDate"
                    without-tips
                    :min="now()"
                    without-time
                />
            </div>

            <div class="mt-3">
                <x-inputs.number label="Average Weight" wire:model="editAverageWeight" />
            </div>
            
            <x-slot name="footer" class="flex justify-end gap-x-4">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" wire:click="cancelEdit" />
                    <x-button primary label="Save" wire:click="editSamplingConfirmation({{ $selectedSamplingId }})" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
