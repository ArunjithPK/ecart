<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               List of Products
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                         role="alert" v-if="$page.props.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.props.message }}</p>
                            </div>
                        </div>
                    </div>
                    <button @click="openModal()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
                       New Products
                    </button>
                    <button style="margin-left: 67%;" @click="triggerFactory()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
                       Create Products By Factory
                    </button>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20">#</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">price</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(row, index) in products" :key="index">

                             <td class="border px-4 py-2">{{index+1 }}</td>
                            <td class="border px-4 py-2">{{ row.title }}</td>
                            <td class="border px-4 py-2">{{ row.description }}</td>
                            <td class="border px-4 py-2">{{ row.price }}</td>
                            <td class="border px-4 py-2">
                                <button @click="edit(row)"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </button>
                                <button @click="deleteRow(row)"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- <pagination

                            :total="Object.keys(this.products).length"
                            :per-page="perPage"
                            @page-changed="loadProducts"/> -->
                    <!--<tailable-pagination-->


                    <!--</tailable-pagination>-->

                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                 role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput1"
                                                       class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                                                <input type="text"
                                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                       id="exampleFormControlInput1" placeholder="Title"
                                                       v-model="form.title">
                                                <div v-if="$page.props.errors.title" class="text-red-500">{{
                                                    $page.props.errors.title }}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="exampleFormControlInput2"
                                                       class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                                <textarea
                                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        id="exampleFormControlInput2" placeholder="Description" style="height: 100px;"
                                                        v-model="form.description"></textarea>
                                                <div v-if="$page.props.errors.description" class="text-red-500">{{$page.props.errors.description }}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="exampleFormControlInput1"
                                                       class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                                                <input type="text"
                                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                       id="exampleFormControlInput1" placeholder="Price"
                                                       v-model="form.price">
                                                <div v-if="$page.props.errors.price" class="text-red-500">
                                                    {{ $page.props.errors.price }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                            <button wire:click.prevent="store()" type="button"
                                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                    v-show="!editMode" @click="save(form)">
                                                Save
                                            </button>
                                        </span>
                                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                            <button wire:click.prevent="store()" type="button"
                                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                                    v-show="editMode" @click="update(form)">
                                                Update
                                            </button>
                                        </span>
                                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                            <button @click="closeModal()" type="button"
                                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                Cancel
                                            </button>
                                        </span>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Pagination from '@/Layouts/Pagination'

    export default {
        components: {
            AppLayout,
            Welcome,
            Pagination,
        },
        props: {
            errors: Array,
            products: Object,
        },
         computed: {
            itemsWithSno() {
                return this.products.map((d, index) => ({...d, sno: index + 1 }))
            }
        },
        data() {
            return {
                perPage: 5,
                editMode: false,
                isOpen: false,
                form: {
                    title: null,
                    description: null,
                    price:0
                },
            }
        },

        methods: {
            openModal() {
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
                this.reset();
                this.editMode = false;
            },
            reset() {
                this.form = {
                    title: null,
                    description: null,
                }
            },
            save(products) {
                this.$inertia.post('/product', products, {
                    preserveScroll: true,
                    onSuccess: page => {

                        if (Object.keys(page.props.errors).length === 0) {
                            this.reset();
                            this.closeModal();
                            Toast.fire({
                                icon: 'success',
                                title: 'Successfully created.'
                            });
                        }
                    },
                })
                this.editMode = false;
            },
            edit(products) {
                this.form = Object.assign({}, products);
                this.editMode = true;
                this.openModal();
            },
            update(products) {
                products._method = 'PATCH';
                this.$inertia.post('/product/edit/' + products.id, products)
                    .then(() => {

                        Toast.fire({
                            icon: 'success',
                            title: 'Successfully updated'
                        });

                    });
                this.reset();
                this.closeModal();
            },
            deleteRow(products) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Won't be able to reverse this",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.value) {
                        products._method = 'DELETE';
                        this.$inertia.post('/product/delete/' + products.id, products)
                            .then(() => {

                                Swal.fire(
                                    'Eliminated!',
                                    'Successfully deleted',
                                    'success'
                                );
                            }).catch(() => {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        });
                    }
                });

                this.reset();
                this.closeModal();
            },

            // loadProducts(page) {
            //     this.$inertia.get("/product?page=" + page)
            //         .then(data => (this.products = data));
            // },

            triggerFactory(){
                this.$inertia.get('/product/factory' )
                    .then(() => {

                        Toast.fire({
                            icon: 'success',
                            title: '10 product successfully created'
                        });

                    });
            }
        },
    }
</script>
