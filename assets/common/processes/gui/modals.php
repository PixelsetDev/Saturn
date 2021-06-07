<?php

    function display_modal_sidebar($title, $contents, $footer): string {
        return '<div class="fixed inset-0 overflow-hidden z-50" x-show="open" @click.away="open = false">
                                        <div class="absolute inset-0 overflow-hidden">
                                            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                            <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex" aria-labelledby="slide-over-heading">
                                                <div class="relative w-screen max-w-md">
                                                    <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                                                        <button @click="open = false" class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                            <span class="sr-only">Close panel</span>
                                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                                                        <div class="px-4 sm:px-6">
                                                            <h2 id="slide-over-heading" class="text-3xl font-medium text-gray-900">
                                                                '.$title.'
                                                            </h2>
                                                        </div>
                                                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                                                            <div class="absolute inset-0 px-4 sm:px-6 h-full">
                                                                '.$contents.'
                                                                <br><br><br><br>
                                                            </div>
                                                        </div>
                                                        '.$footer.'
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>';
    }

    function display_modal($colour, $title, $contents, $footer): string {
        return '<div x-show="open" @click.away="open = false" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-'.$colour.'-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-'.$colour.'-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                '.$title.'
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    '.$contents.'
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                '.$footer.'
                            </div>
                        </div>
                    </div>';
    }