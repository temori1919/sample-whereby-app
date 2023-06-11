<script setup lang="ts">
import { ref, onBeforeMount } from 'vue';
import axios from 'axios';
import ChatRoomDialog from './ChatRoomDialog.vue';

  const meetingId = ref('');
  const hostRoomUrl = ref('');
  const guestRoomUrl = ref('');
  const name = ref('');
  const showDialog = ref(false);

  const password = ref('');
  const instance = axios.create({
    baseURL: import.meta.env.VITE_BACKEND_URL,
  });

  const loading = ref(false);

  const create = () => {
    loading.value = true;
    instance.post('/api/create', {
      password: password.value
    }, {
    }).then((res) => {
      meetingId.value = res.data.meetingId;
      hostRoomUrl.value = `${res.data.hostRoomUrl}&displayName=${name.value}&minimal&screenshare=off&chat=off&people=off&settingsButton=off`;
      guestRoomUrl.value = `${location.protocol}//${location.hostname}:${location.port}${res.data.roomName}`;
      showDialog.value = true;
    }).catch((err) => {
      console.error(err);
    }).finally(() => {
      loading.value = false;
    });
  }

  const remove = () => {
    loading.value = true;
    instance.post(`/api/delete/${meetingId.value}`, {
      password: password.value
    }, {
    }).then(() => {
      meetingId.value = '';
      hostRoomUrl.value = '';
      guestRoomUrl.value = '';
      showDialog.value = false;
    }).catch((err) => {
      console.error(err);
    }).finally(() => {
      loading.value = false;
    });
  }

  onBeforeMount(() => {
    const guestRoomName = location.pathname

    if (guestRoomName !== '/') {
      showDialog.value = true;
      hostRoomUrl.value = `https://sample.whereby.com${guestRoomName}?minimal&leaveButton=on&people=off`;
    }
  })
</script>

<template>
  <v-app id="inspire">
    <v-main>
      <v-container class="d-flex justify-center align-center h-100">
        <v-card
          variant="outlined"
          color="cyan-accent-4"
          min-width="400"
        >
          <v-card-title class="text-h5">
            Make rooms
          </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="password"
            label="PW"
            required
            type="password"
          ></v-text-field>
          <v-text-field
            v-model="name"
            label="name"
            required
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn
            :loading="loading"
            variant="text"
            color="green-darken-4"
            class="mr-2"
            @click="create"
          >
            create
          </v-btn>
        </v-card-actions>
      </v-card>
      <ChatRoomDialog 
        :loading="loading"
        :show="showDialog"
        :roomUrl="hostRoomUrl"
        :guest-url="guestRoomUrl"
        @remove="remove"
      ></ChatRoomDialog>
      </v-container>
    </v-main>
  </v-app>
</template>