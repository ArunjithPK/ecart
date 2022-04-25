<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Your Cart
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                         role="alert" v-if="Object.keys(this.usercarts).length == 0">
                        <div class="flex">
                            <div>
                                <p class="text-sm">Your cart is empty!</p>
                            </div>
                        </div>
                    </div>

                    <table class="table-fixed w-full" v-if="Object.keys(this.usercarts).length > 0">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">price</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in usercarts" :key="row.id">
                            <td class="border px-4 py-2">{{ row.products.title }}</td>
                            <td class="border px-4 py-2">{{ row.products.description }}</td>
                            <td class="border px-4 py-2">₹{{ row.products.price }}</td>
                            <td class="border px-4 py-2">{{ row.quantity }}</td>
                            <td class="border px-4 py-2">₹{{ poductAmountCal(row.products.price,row.quantity) }}</td>

                            <td class="border px-4 py-2">

                                <button @click="removeFromCart(row)"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Remove
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2" colspan="4">Total Amount</td>
                            <td class="border px-4 py-2"  colspan="2">₹{{total}}</td>
                        </tr>
                        <tr>
                            <td colspan="6">

                            <form>
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="">
                                        <div class="mb-4">
                                            <label for="exampleFormControlInput2"
                                                    class="block text-gray-700 text-sm font-bold mb-2">
                                                    Delivery Address :
                                            </label>
                                            <textarea
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput2" placeholder="Delivery Address" style="height: 100px;"
                                                    v-model="form.delivery_address">
                                            </textarea>
                                            <div v-if="$page.props.errors.delivery_address" class="text-red-500">
                                                {{$page.props.errors.delivery_address }}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="exampleFormControlInput1"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                                            <input type="text"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    id="exampleFormControlInput1" placeholder="phone"
                                                    v-model="form.phone">
                                            <div v-if="$page.props.errors.phone" class="text-red-500">{{
                                                $page.props.errors.phone }}
                                            </div>
                                        </div>

                                        <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2" >
                                            Note :  Cash on Delivery Only
                                        </label>

                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                        <button type="button"
                                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base text-white leading-6 font-bold py-2 px-4 rounded"
                                                @click="placeOrder(form)">
                                            Place Order
                                        </button>
                                    </span>
                                    </div>
                                </form>

                            </td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: {
            errors: Array,
            usercarts: Array,
        },
        data() {
            return {
                amount: 0,
                totalAmount: 0,
                form: {
                    delivery_address: null,
                },
            }
        },
        computed: {
            total: function () {
                return this.usercarts.reduce((total, cart) => total + parseFloat(cart.products.price) * parseInt(cart.quantity), 0);
            }
        },
        methods: {
            poductAmountCal(rate,quantity) {
                return parseFloat(rate) * parseFloat(quantity);
            },

            removeFromCart(cart) {
                cart._method = 'DELETE';
                this.$inertia.post('/user/carts/delete/' + cart, cart)
                    .then(() => {

                        Swal.fire(
                            'Removed!',
                            'Successfully deleted',
                            'success'
                        );
                    }).catch(() => {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        // footer: '<a href="#">why do i have an error?</a>'
                    });
                });
            },
            placeOrder(cart) {
                this.$inertia.post('/place/order', cart, {
                    preserveScroll: true,
                    onSuccess: page => {
                        if (Object.keys(page.props.errors).length === 0) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Successfully created.'
                            });
                        }
                    },
                })
            },

        },
    }
</script>
