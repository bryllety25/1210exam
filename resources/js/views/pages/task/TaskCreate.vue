<script setup>
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';

const data = reactive({
    dialog: false
});

// let dialog = ref(false);
defineExpose({ openUpdateForm, data })

let form = ref({
    title: "",
    description: "",
    file: "",
    status: "Todo",
});

const rules = {
    title: { required },
    description: {},
    file: {},
    status: {},
}

const v$ = useVuelidate(rules, form)

const $toast = useToast();
const emit = defineEmits(['newTask'])
async function save() {
    this.v$.$touch()
    if (!this.v$.$invalid) {
        try {
            var url = '/api/task';
            if (form.value.id)
                url = url + '/' + form.value.id + '?_method=PUT'
            let response = await axios.post(url, form.value, {
                headers: {
                    Authorization: 'Bearer ' + $cookies.get('authorization'),
                    'Content-Type': 'multipart/form-data'
                }
            });
            $toast.success("New Task Created");
            emit("newTask");
            data.dialog = false;
        } catch (error) {
            if (error.response.status == 422) {
                error.response.data.forEach(value => {
                    console.log(value);
                    $toast.error(value.message);
                })
            }
        }
    }
    else {
        $toast.error("Invalid");
    }
}

function reset() {
    form.value = {
        title: "",
        description: "",
        file: "",
        status: "Todo",
    };
}

function openUpdateForm(record) {
    form.value = {
        id: record.id,
        title: record.title,
        description: record.description,
        status: record.status,
        file: null,
        filename: record.file
    };
    data.dialog = true;
}


</script>

<template>
    <v-btn color="primary" @click="data.dialog = true; reset()">
        New Task
    </v-btn>

    <v-dialog v-model="data.dialog" width="auto">
        <v-card>
            <v-card-text>
                <VForm @submit.prevent="save()">
                    <VRow>
                        <VCol cols="12">
                            <VRow no-gutters>
                                <VCol cols="12" md="3">
                                    <label for="firstName">Title</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                    <VTextField id="title" v-model="form.title" placeholder="New Task"
                                        @input="v$.title.$touch" @blur="v$.title.$touch"
                                        :error-messages="v$.title.$errors.map(e => e.$message)" persistent-placeholder />
                                </VCol>
                            </VRow>
                        </VCol>

                        <VCol cols="12">
                            <VRow no-gutters>
                                <VCol cols="12" md="3">
                                    <label for="email">Description</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                    <v-textarea clearable v-model="form.description" placeholder="Description of your task"
                                        @input="v$.description.$touch" @blur="v$.description.$touch"
                                        :error-messages="v$.description.$errors.map(e => e.$message)"
                                        persistent-placeholder></v-textarea>

                                </VCol>
                            </VRow>
                        </VCol>

                        <VCol cols="12">
                            <VRow no-gutters>
                                <VCol cols="12" md="3">
                                    <label for="mobile">Attach File </label>

                                    <v-btn class="ma-2" v-if="form.filename" :href="'/api/task/download/' + form.id"
                                        density="compact" download>
                                        <v-icon icon="mdi-download"></v-icon>
                                    </v-btn>

                                </VCol>

                                <VCol cols="12" md="9">

                                    <v-file-input v-model="form.file" label="File input" @input="v$.file.$touch"
                                        @blur="v$.file.$touch" :error-messages="v$.file.$errors.map(e => e.$message)"
                                        persistent-placeholder></v-file-input>
                                </VCol>
                            </VRow>
                        </VCol>

                        <VCol cols="12">
                            <VRow no-gutters>
                                <VCol cols="12" md="3">
                                    <label for="password">Status</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                    <VTextField id="status" v-model="form.status" placeholder="Status" readonly="true"
                                        persistent-placeholder />
                                </VCol>
                            </VRow>
                        </VCol>

                        <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
                            <VBtn type="submit">
                                Submit
                            </VBtn>
                            <VBtn color="secondary" variant="tonal" @click="data.dialog = false">
                                Cancel
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>

            </v-card-text>
        </v-card>
    </v-dialog>
</template>
