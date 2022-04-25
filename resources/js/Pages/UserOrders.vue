
<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Your Orders
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                         role="alert" v-if="Object.keys(this.orders).length == 0">
                        <div class="flex">
                            <div>
                                <p class="text-sm">Please order something!</p>
                            </div>
                        </div>
                    </div>

                    <table class="table-fixed w-full" v-if="Object.keys(this.orders).length > 0">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Purchased on</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Address & phone</th>
                            <th class="px-4 py-2">Products</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in orders" :key="row.id">
                            <td class="border px-4 py-2">{{ formatDate(row.created_at) }}</td>
                            <td class="border px-4 py-2">₹{{ row.price }}</td>
                            <td class="border px-4 py-2">
                                <p>{{ row.delivery_address }} </p>
                                <p>{{ row.phone }} </p>

                            </td>
                            <td class="border px-4 py-2">
                                <table class="table-fixed w-full" style="border: 1px solid;" v-if="Object.keys(row.user_cart).length > 0">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2" style="border: 1px solid;">Tittle</th>
                                            <th class="px-4 py-2" style="border: 1px solid; ">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tr v-for="cart in row.user_cart" :key="cart.id">
                                        <td style="border: 1px solid;text-align: center"> {{cart.products.title}}</td>
                                        <td style="border: 1px solid;text-align: center"> {{cart.quantity}}</td>
                                    </tr>
                                </table>


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
    import moment from 'moment';

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: {
            errors: Array,
            orders: Object,
        },
        data() {
            return {

            }
        },
        computed: {

        },
        methods: {
            formatDate(value){
                if (value) {
                    return moment(String(value)).format('MMM D, YYYY h:mm A')
                }
            },
        },
    }
</script>
