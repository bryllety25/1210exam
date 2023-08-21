<script setup>
import TaskCreate from '@/views/pages/task/TaskCreate.vue';
import TaskDelete from '@/views/pages/task/TaskDelete.vue';
import axios from 'axios';
import moment from 'moment';
import { onMounted, ref } from 'vue';
const $cookies = inject('$cookies');
const childRef = ref()
var dialog = ref(false);

const data = reactive({
    records: [],
    meta: {}
});
let search = ref("")
let sort = ref("ASC")
let limit = ref(10)
let paginate = ref(1)
const taskForm = ref()
const confirm = ref()

onMounted(() => {
    getRecord()
})

async function getRecord() {
    var url = '/api/task';

    url = url + "?limit=" + limit.value
    url = url + "&page=" + paginate.value
    url = url + "&sort=" + sort.value
    if (search.value)
        url = url + "&search=" + search.value

    let response = await axios.get(url, {
        headers: {
            Authorization: 'Bearer ' + $cookies.get('authorization')
        }
    });
    data.records = response.data.data
    data.meta = response.data.meta
    const instance = getCurrentInstance();
}

function updateForm(record) {
    taskForm.value.openUpdateForm(record);
}

function deleteDialog(record) {
    confirm.value.open(
        "Confirm",
        "Are you sure you want to delete this record?",
        record.id
    )
}

async function updateStatus(record) {
    var url = '/api/task';
    url = url + '/update-status/' + record.id + '?_method=PUT'
    let response = await axios.post(url, { status: record.status }, {
        headers: {
            Authorization: 'Bearer ' + $cookies.get('authorization'),
            'Content-Type': 'multipart/form-data'
        }
    });
    $toast.success("Status Change Task");
}



</script>

<template>
    <VCard>
        <v-card-title>
            <span class="font-weight-bold">List of Task</span>
        </v-card-title>
        <v-container>
            <v-row>
                <v-col md="3">
                    <v-text-field v-model="search" @input="getRecord" :loading="loading" density="compact" label="Search"
                        append-inner-icon="mdi-magnify" hide-details @click:append-inner="onClick"></v-text-field>
                </v-col>
                <v-col md="3">
                    <v-select label="Sort" v-model="sort" @update:modelValue="getRecord" density="compact"
                        :items="['DESC', 'ASC']"></v-select>
                </v-col>
                <v-col md="6">
                    <div class="float-right">
                        <TaskCreate @newTask="getRecord" ref="taskForm" />
                    </div>
                </v-col>
            </v-row>
        </v-container>

        <VTable>
            <thead>
                <tr>
                    <th>
                        Task
                    </th>
                    <th width="40%">
                        Description
                    </th>
                    <th>
                        Date Created
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(item, index) in data.records" :key="index">
                    <td>
                        {{ item.title }}
                    </td>
                    <td class="text-center">
                        {{ item.description }}
                    </td>
                    <td class="text-center">
                        {{ moment(item.created_at).format('YYYY-MM-DD') }}
                    </td>
                    <td class="text-center">
                        <v-select v-model="item.status" @update:modelValue="updateStatus(item)" density="compact"
                            :items="['Todo', 'In Progress', 'Completed']"></v-select>
                        {{ }}
                    </td>
                    <td class="text-center">
                        <v-menu :location="location">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props">
                                    Action
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-item variant="plain" color="warning" value="update">
                                    <v-list-item-title @click.prevent="updateForm(item)">View / Update</v-list-item-title>
                                </v-list-item>
                                <v-list-item variant="error" color="error" value="delete">
                                    <v-list-item-title @click="deleteDialog(item)">Delete</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                </tr>
            </tbody>
        </VTable>

        <div class="float-right">
            <v-pagination v-model="paginate" @update:modelValue="getRecord" :length="data.meta.last_page"
                :total-visible="7"></v-pagination>
        </div>
    </VCard>
    <TaskDelete @accept="getRecord" ref="confirm" />
</template>
