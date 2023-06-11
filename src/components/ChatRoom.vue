<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';

  const room = ref('');
  const password = ref('');

  const instance = axios.create({
    baseURL: 'https://api.whereby.dev',
    headers: {
      Authorization: `Bearer ${import.meta.env.VITE_API_KEY}`,
      'Content-Type': 'application/json',
    }
  });

  const create = () => {
    const params = {
      endDate: '2099-02-18T14:23:00.000Z',
      fields: ['hostRoomUrl'],
    };

    instance.post('v1/meetings', params).then((res) => {
      room.value = res.data.roomUrl
    }).catch((err) => {
      console.error(err);
    });
  }
</script>

<template>
  <v-app id="inspire">
    <v-navigation-drawer
      model-value
      class="pt-4"
      color="grey-lighten-3"
      rail
    >
      <v-avatar
        v-for="n in 6"
        :key="n"
        :color="`grey-${n === 1 ? 'darken' : 'lighten'}-1`"
        :size="n === 1 ? 36 : 20"
        class="d-block text-center mx-auto mb-9"
      ></v-avatar>
    </v-navigation-drawer>

    <v-main>
      <v-container>
        <v-form @submit.prevent>
          <v-row>
            <v-col>
              <v-text-field
                v-model="password"
                label="First name"
              ></v-text-field>
              <v-btn
                variant="flat"
                type="submit"
                color="secondary"
                class="mr-2"
                @click="create"
              >
                ルーム作成
              </v-btn>
              <v-btn
                type="submit"
                variant="flat"
                color="error"
                @click="remove"
              >
                ルーム削除
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
        <v-row v-if="room.length">
          <v-col>
            <whereby-embed minimal room="{{ room }}"></whereby-embed>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>