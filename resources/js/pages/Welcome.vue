<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
// TODO: remove the InventoryItem content from this page
// TODO:revert this back to a simple welcome page
interface InventoryItem {
    id: number;
    name: string;
    quantity: number;
    sku: string;
    notification_sent: boolean;
}

interface InventoryItemForm {
    name: string;
    quantity: number;
    sku: string;
    notification_sent: boolean;
}

const formData = useForm<InventoryItemForm>({
    name: '',
    quantity: 0,
    sku: '',
    notification_sent: false,
});

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
                class="flex w-full max-w-[335px] flex-col gap-3 overflow-hidden rounded-lg lg:max-w-4xl lg:flex-col"
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
                        <h1
                            class="text-center text-3xl font-bold tracking-tight"
                        >
                            All Inventory Items
                        </h1>
                    </div>
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 rounded-lg border border-gray-200"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                    >
                                        ID
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                    >
                                        Quantity
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                    >
                                        SKU
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="inventoryItem in inventoryItems"
                                    :key="inventoryItem.id"
                                    class="transition-colors hover:bg-gray-50"
                                >
                                    <td
                                        class="px-6 py-4 text-sm whitespace-nowrap text-gray-900"
                                    >
                                        {{ inventoryItem.id }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm whitespace-nowrap text-gray-900"
                                    >
                                        {{ inventoryItem.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm whitespace-nowrap text-gray-900"
                                    >
                                        {{ inventoryItem.quantity }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm whitespace-nowrap text-gray-900"
                                    >
                                        {{ inventoryItem.sku }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm whitespace-nowrap"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'inventory-item.delete',
                                                    inventoryItem.id,
                                                )
                                            "
                                            method="delete"
                                            class="font-medium text-red-600 transition-colors hover:text-red-900 hover:cursor-pointer"
                                        >
                                            Delete
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <form
                        @submit.prevent="
                            formData.post(route('inventory_item.store'))
                        "
                        class="flex flex-col items-center gap-3"
                    >
                        <h1>Add a New Inventory Item</h1>
                        <label
                            >Name:
                            <input
                                v-model="formData.name"
                                type="text"
                                placeholder="Add a name for this new item..."
                        /></label>
                        <div class="text-red-500" v-if="formData.errors.name">
                            {{ formData.errors.name }}
                        </div>

                        <label
                            >Quantity:
                            <input
                                v-model="formData.quantity"
                                type="number"
                                placeholder="Add quantity for this new item..."
                        /></label>
                        <div
                            class="text-red-500"
                            v-if="formData.errors.quantity"
                        >
                            {{ formData.errors.quantity }}
                        </div>

                        <label
                            >SKU:
                            <input
                                v-model="formData.sku"
                                type="text"
                                maxlength="10"
                                placeholder="Add a SKU for this new item..."
                        /></label>
                        <div class="text-red-500" v-if="formData.errors.sku">
                            {{ formData.errors.sku }}
                        </div>

                        <button
                            type="submit"
                            class="w-fit rounded-xl bg-blue-500 px-4 py-0.5 transition-all duration-300 hover:cursor-pointer hover:bg-blue-600"
                        >
                            Submit
                        </button>
                    </form>
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
