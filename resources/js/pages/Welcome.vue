<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

interface InventoryItem {
    id: number,
    name: string,
    quantity: number,
    sku: string,
    notification_sent: boolean
}

interface InventoryItemForm {
    name: string;
    quantity: number;
    sku: string;
}

const formData = useForm<InventoryItemForm>({
    name: '',
    quantity: 0,
    sku: '',
})

withDefaults(
    defineProps<{
        canRegister: boolean;
        inventoryItems: InventoryItem[];
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
    >
        <header
            class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl"
        >
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <main
                class="flex w-full max-w-[335px] flex-col overflow-hidden rounded-lg lg:max-w-4xl lg:flex-col gap-3"
            >
                <div
                    class="flex-1 rounded-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    Welcome to my Inventory Item Job Test Website
                </div>

                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <div>
                        <h1 class="text-center text-3xl font-bold tracking-tight">All Inventory Items</h1>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>SKU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(inventoryItem, index) in inventoryItems" :key="index">
                                <td>{{inventoryItem.id}}</td>
                                <td>{{inventoryItem.name}}</td>
                                <td>{{inventoryItem.quantity}}</td>
                                <td>{{inventoryItem.sku}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                    <form @submit.prevent="formData.post(route('inventory_item.create'))" class="flex flex-col gap-3 items-center">
                        <h1>Add a New Inventory Item</h1>
                        <label>Name: <input v-model="formData.name" type="text" placeholder="Add a name for this new item..."/></label>
                        <div class="text-red-500" v-if="formData.errors.name">{{formData.errors.name}}</div>
                        <label>Quantity: <input v-model="formData.name" type="number" placeholder="Add quantity for this new item..."/></label>
                        <div class="text-red-500" v-if="formData.errors.quantity">{{formData.errors.quantity}}</div>
                        <label>SKU: <input v-model="formData.name" type="text" maxlength="10" placeholder="Add a SKU for this new item..."/></label>
                        <div class="text-red-500" v-if="formData.errors.sku">{{formData.errors.sku}}</div>
                        <button type="submit" class="w-fit px-4 py-0.5 rounded-xl hover:cursor-pointer bg-blue-500 hover:bg-blue-600 transition-all duration-300">Submit</button>
                    </form>
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
