<script setup lang="ts">
import { ref } from 'vue';
  type Props = {
      show?: boolean;
      loading?: boolean;
      roomUrl?: string;
      guestUrl?: string;
  };

  const props = withDefaults(defineProps<Props>(), {
    show: false,
    loading: false,
    roomUrl: '',
    guestUrl: '',
  });

  type Emits = {
    (e: 'remove'): void;
  };

  const emit = defineEmits<Emits>();

  const handleRemove = () => {
    emit('remove');
  };

  const snackbar = ref(false);

  const isHost = () => {
    return props.guestUrl.length
  }

  const copy = () => {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(props.guestUrl).then(() => {
        snackbar.value = true;
      });
    }
  }
</script>

<template>
  <v-dialog
    :model-value="show"
    :scrim="false"
    fullscreen
  >
    <v-card min-width="1000">
      <v-system-bar
        color="#363636"
        class="pb-5"
      >
        <v-btn
          v-if="isHost()"
          class="mt-7"
          variant="plain"
          icon="mdi-clipboard-check-multiple"
          size="small"
          color="white"
          @click="copy"
        >
          <v-icon>mdi-clipboard-check-multiple</v-icon>
          <v-tooltip
            activator="parent"
            location="bottom"
          >ゲスト用のURLをコピー</v-tooltip>
        </v-btn>
        <v-btn
          v-if="isHost()"
          class="mt-7"
          :loading="loading"
          variant="plain"
          size="small"
          color="white"
          @click="handleRemove"
        >
          <v-icon>mdi-door-closed</v-icon>
          <v-tooltip
            activator="parent"
            location="bottom"
          >ルーム退出</v-tooltip>
        </v-btn>
      </v-system-bar>
      <iframe
        :src="roomUrl"
        allow="camera; microphone; speaker; fullscreen; display-capture">
      </iframe>
    </v-card>
  </v-dialog>
  <v-snackbar
    v-model="snackbar"
    color="success"
    timeout="1500"
  >Copied to clipboard.</v-snackbar>
</template>

<style scoped>
iframe {
  height: 100%;
  width: 100%;
  border: none;
};
</style>