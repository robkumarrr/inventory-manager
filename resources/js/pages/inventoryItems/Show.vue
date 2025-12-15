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
        <div>Inventory Item</div>
        <div>{{ inventoryItem.id }}</div>
    </AppLayout>
</template>

<style scoped></style>
