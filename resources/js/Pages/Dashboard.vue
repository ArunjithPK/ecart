<template>
    <app-layout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2> -->
        </template>

            <div class="bg-white">
                <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                    <h2 class="sr-only">Products</h2>

                    <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">

                    <div  class="group"  v-for="row in products" :key="row.id">
                        <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
                        <img  :src="getImgUrl(pic)" v-bind:alt="pic" class="w-full h-full object-center object-cover group-hover:opacity-75">
                        </div>
                        <h2 class="mt-4 text-sm text-gray-700">{{ row.title }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ row.description }}</p>
                        <span class="mt-1 text-lg font-medium text-gray-900">₹{{ row.price }}</span>

                        <button @click="addToCart(row)" style="margin-left: 60%;" class="inline-flex items-center justify-center w-10 h-10 mr-2 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">
                            <svg class="_1KOMV2" width="16" height="16" viewBox="0 0 16 15" xmlns="http://www.w3.org/2000/svg"><path class="" d="M15.32 2.405H4.887C3 2.405 2.46.805 2.46.805L2.257.21C2.208.085 2.083 0 1.946 0H.336C.1 0-.064.24.024.46l.644 1.945L3.11 9.767c.047.137.175.23.32.23h8.418l-.493 1.958H3.768l.002.003c-.017 0-.033-.003-.05-.003-1.06 0-1.92.86-1.92 1.92s.86 1.92 1.92 1.92c.99 0 1.805-.75 1.91-1.712l5.55.076c.12.922.91 1.636 1.867 1.636 1.04 0 1.885-.844 1.885-1.885 0-.866-.584-1.593-1.38-1.814l2.423-8.832c.12-.433-.206-.86-.655-.86" fill="#fff"></path></svg>
                        </button>

                    </div>

                    </div>
                </div>
            </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    // import ProductList from '@/Pages/Product/ProductList'

    export default {
        components: {
            AppLayout,
            Welcome,
            // ProductList,
        },
        props: {
            errors: Object,
            products: Array,

        },
        methods: {
            getImgUrl(){
                let no = parseInt(Math.random()*8);
                if(no == 0){
                    no = parseInt(Math.random()*8);
                }
                return 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-0' + no + ".jpg";
            },

            addToCart(products) {
                this.$inertia.post('/user/carts', products, {
                    preserveScroll: true,
                    onSuccess: page => {
                        if (Object.keys(page.props.errors).length === 0) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Added to cart.'
                            });
                        }
                    },
                })

            },
        },
    }
</script>
