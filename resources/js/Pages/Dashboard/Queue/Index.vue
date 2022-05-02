<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import { Icon } from '@iconify/vue';
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

const queues =  defineProps([])

const localQueues = ref([]);

const isLoading = ref(false);

onMounted(() => {
    getJobs()
});

function getJobs(){
    isLoading.value = true;
    axios.get('/api/queued-jobs').then(response => {
        localQueues.value = response.data.queues;
        isLoading.value = false;
    });
}

function runJob(jobId){
    isLoading.value = true;
    axios.post('/dashboard/queue/run-job', {
        id: jobId
    }).then(response => {
        getJobs();
        isLoading.value = false;
    }).catch(error => {
        console.log(error);
    });
}

</script>

<template>
    <AppLayout title="Queue Management">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Queue Management
            </h2>
             <div v-if="isLoading">
                <PulseLoader class="flex justify-center" />
             </div>
        </template>


            <div v-if="!isLoading">
                <div  class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table v-if="localQueues.length > 0" class="min-w-full">
                                    <thead class="border-b">
                                        <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            #
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Type
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Attempts
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Created At
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Actions
                                        </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="queue in localQueues" :key="queue.id" class="border-b">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ queue.id }}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{queue.payload.displayName}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{queue.attempts}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{queue.created_at}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                <div class="">
                                                    <button
                                                        @click="runJob(queue.id)"
                                                        type="buttom"
                                                        title="Click to run this job!"
                                                    >
                                                        <Icon icon="fe:play" width="36" height="36" />
                                                    </button>
                                                    <button type="buttom" title="Click to run this job!">
                                                        <Icon icon="fe:trash" width="36" height="36" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>

                                    <p v-else>
                                       <PulseLoader class="flex justify-center" />
                                    </p>

                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </AppLayout>
</template>
