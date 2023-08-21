<script setup>
import axios from 'axios';
import { reactive } from 'vue';

const emit = defineEmits(['acccept'])

const data = reactive({
    dialog: false,
    title: "",
    message: "",
    id: null,
    options: {
        color: "grey lighten-3",
        width: 400,
        zIndex: 200,
        noconfirm: false
    },
});


const open = (title, message, id, options) => {
    data.dialog = true;
    data.title = title;
    data.message = message;
    data.id = id
    data.options = Object.assign(data.options, options);

}
defineExpose({ open, data })

async function agree() {
    var url = '/api/task/' + data.id;
    let response = await axios.delete(url, {
        headers: {
            Authorization: 'Bearer ' + $cookies.get('authorization')
        }
    });
    data.records = response.data.data

    emit("accept");
    data.dialog = false;
}
function cancel() {
    data.dialog = false;
}

</script>

<template>
    <v-dialog v-model="data.dialog" :max-width="data.options.width" :style="{ zIndex: data.options.zIndex }"
        @keydown.esc="cancel">
        <v-card>
            <v-toolbar dark :color="data.options.color" dense flat>
                <v-toolbar-title class="text-body-2 font-weight-bold grey--text">
                    {{ data.title }}
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text v-show="!!data.message" class="pa-4 black--text" v-html="data.message"></v-card-text>
            <v-card-actions class="pt-3">
                <v-spacer></v-spacer>
                <v-btn v-if="!data.options.noconfirm" color="grey" text class="body-2 font-weight-bold"
                    @click.native="cancel()">Cancel</v-btn>
                <v-btn color="primary" class="body-2 font-weight-bold" outlined @click="agree">OK</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
