<template>
    <!--
    SPDX-FileCopyrightText: Tobias Knöppler <tobias@knoeppler.net>
    SPDX-License-Identifier: AGPL-3.0-or-later
    -->
	<div class="wrapper">
		<div class="guest-box login-box">
			<h3>Scan the QR code with your Nextcloud App to login</h3>
			<img v-if="qrImage" :src="qrImage" :alt="`${clientUUId}`"/>
		</div>
	</div>
</template>

<script>
import qr from 'qrcode'
import {NcGuestContent as GuestContent} from "@nextcloud/vue";

import '@nextcloud/dialogs/styles/toast.scss'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'

export default {
	name: 'App',
	components: {
		GuestContent
	},
	data() {
		return {
			clientUUId: window.crypto.randomUUID(),
			pollJob: null,
			qrImage: undefined
		}
	},
	computed: {
	},
	/**
	 * Fetch list of notes when the component is loaded
	 */
	async mounted() {
		this.pollJob = setInterval(this.attemptLogin, 3000)
		this.qrImage = await qr.toDataURL(this.clientUUId);
	},

	methods: {
		async attemptLogin() {

		}
	},
}
</script>
<style scoped lang="scss">
.wrapper {
	width: 100%;
	margin-top: 10vh;
	box-sizing: border-box;
	display: flex;
	justify-content: center;
	align-items: center;
}
.login-box {
	width: 320px;
	box-sizing: border-box;
	display: inline-block;
	text-align: center;
	font-size: var(--default-font-size);
	font-weight: normal !important;
	color: var(--color-main-text);
	background-color: var(--color-main-background);
	padding: 16px;
	border-radius: var(--border-radius-large);
	box-shadow: 0 0 10px var(--color-box-shadow);
}
.login-box.guest-box, footer {
	color: var(--color-main-text);
	background-color: var(--color-main-background-blur);
	-webkit-backdrop-filter: var(--filter-background-blur);
	backdrop-filter: var(--filter-background-blur);
}
footer {
// Usually the same size as the login box, but allow longer texts
	min-width: 320px;
	box-sizing: border-box;
// align with login box
	box-shadow: 0 0 10px var(--color-box-shadow);
// set border to pill style and adjust padding for it
	border-radius: var(--border-radius-pill);
	padding: 6px 24px;
// always show above bottom
	margin-bottom: 1rem;
	min-height: unset;

// reset margin to reduce height of pill
	p.info {
		margin: auto 0px;
	}
}
</style>
