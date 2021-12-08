<template>
    <div v-if="approving" class="row">

        <div class="col-12">
            <h2>Approve Request</h2>
        </div>
        <div class="col-12">
            <slot></slot>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="send-back-message">Message (Optional)</label>
                <textarea name="message" id="approval-message" class="phrase form-control" aria-describedby="approval-message-help" v-model="message"></textarea>
                <input-error :error="errors.message"></input-error>
            </div>
        </div>
        <div class="w-100"></div>
        <div class="col">
            <input type="hidden" name="response" :value="response">
            <button type="submit" class="btn btn-success"><i class="fas fa-thumbs-up"></i> Save Approved</button>
            <button :key="'btn-send-back'" type="button" class="btn btn-light" @click.prevent="pickResponse('Sent Back')"><i class="fas fa-undo"></i> Send Back</button>
        </div>

    </div>
    <div v-else class="row">

        <div class="col-12">
            <h2>Send Request Back</h2>
        </div>
        <div class="col-12">
            <slot></slot>
        </div>
        <div class="col">
            <div class="mw-500 alert border rounded">
                Use Send-Back if the request needs to be changed by the original requester:
                <span style="border-bottom: 2px solid #ddd;">{{ originalSubmitter }}</span>.
                Requester will be notified. This appointment request will go back to the <strong>Creating</strong> stage
                so the requester can revise it. It will then need to be submitted again for <strong>Department</strong>
                approval.
            </div>
        </div>
        <div class="w-100"></div>
        <div class="col">
            <div class="form-group">
                <label for="send-back-message">Message <em class="required">*</em></label>
                <textarea name="message" id="send-back-message" class="phrase form-control" aria-describedby="send-back-message-help" v-model="message"></textarea>
                <input-error :error="errors.message"></input-error>
                <div class="form-text text-muted" id="send-back-message-help">Required. What needs to change for this to be approved?</div>
            </div>
        </div>
        <div class="w-100"></div>
        <div class="col">
            <input type="hidden" name="response" :value="response">
            <button type="submit" class="btn btn-danger" @click="validateAndSubmit($event)"><i class="fas fa-undo"></i> Save Sent Back</button>
            <button :key="'btn-approve'" type="button" class="btn btn-light" @click.prevent="pickResponse('Approved')"><i class="fas fa-thumbs-up"></i> Approve</button>
        </div>

    </div>
</template>

<script>
    import InputError from '../components/InputError';
    export default {
        props: {
            responseLabel: {
                type: String,
                required: false,
                default: 'What do you want to do?'
            },
            approval_id: {
                type: Number,
                required: false,
                default: null
            },
            defaultResponse: {
                type: String,
                required: false,
                default: 'Approved'
            },
            requireResponse: {
                type: Boolean,
                required: false,
                default: true
            },
            originalSubmitter: {
                type: String,
                required: true
            },
            originalSubmitterId: {
                type: String,
                required: true
            }
        },
        data() {
            let data = {
                response: this.defaultResponse,
                message: '',
                errors: {
                    message: '',
                    sendBackName: '',
                },
                options: [
                    {label: 'No response', value: ''},
                    {label: 'Approve', value: 'Approved'},
                    {label: 'Send back', value: 'Sent Back'}
                ]
            };
            if (this.requireResponse) {
                data.options = [
                    {label: 'Approve', value: 'Approved'},
                    {label: 'Send back', value: 'Sent Back'}
                ]
            }
            return data;
        },
        computed: {
            approving() {
                return this.response === 'Approved';
            },
            sendingBack() {
                return this.response === 'Sent Back';
            }
        },
        methods: {
            pickResponse(value) {
                this.response = value;
            },
            selectedOption(value) {
                return {
                    'option-selected': value === this.response
                };
            },
            validateAndSubmit(e) {
                let valid = true;
                if (!this.message) {
                    valid = false;
                    this.errors.message = 'Message is required when sending back.';
                }
                if (!valid) {
                    e.preventDefault();
                }
            }
        },
        components: {
            'input-error': InputError
        }
    }
</script>