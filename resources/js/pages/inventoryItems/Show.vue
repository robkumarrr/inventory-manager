<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, InventoryItem, InventoryItemForm } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { dashboard } from '@/routes';

defineProps<{
    inventoryItem: InventoryItem;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Inventory Item',
        href: route('inventory-item.show', 1),
    },
];
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-10">
            <h1 class="text-2xl">Inventory Item</h1>
            <div>Item ID: {{ inventoryItem.id }}</div>
            <div>Item Name: {{ inventoryItem.name }}</div>
            <div>Item SKU: {{ inventoryItem.sku }}</div>
            <div>Notification Sent: {{ inventoryItem.notification_sent ? '[ X ]' : '[  ]' }}</div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
