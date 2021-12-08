<template>
    <div class="per-diem">
        <div class="per-diem__row">
            <div class="per-diem__heading">Lodging</div>

            <slot name="lodging"></slot>

            <div class="per-diem__inputs">
                <label for="per-diem-lodging-nights" class="per-diem__label">Lodging Nights</label>
                <input type="text" id="per-diem-lodging-nights" name="nights" class="form-control" v-model="nights">

                <label for="per-diem-lodging-rate" class="per-diem__label mt-3">US GSA Per Diem</label>
                <input-prefix prefix="$">
                    <input type="text" id="per-diem-lodging-rate" name="lodging_pd" class="form-control" v-model="lodgingPd">
                </input-prefix>

                <div class="per-diem__label mt-3">Lodging Limit</div>
                <div class="per-diem__calculated">{{ lodgingLimit }}</div>
                <div v-if="lodgingLimit" class="per-diem__help">
                    ${{ lodgingPd }} &times; {{ nights }} nights
                </div>

                <label for="per-diem-lodging" class="per-diem__label mt-3">Actual Lodging</label>
                <input-prefix prefix="$">
                    <input type="text" id="per-diem-lodging" name="lodging" class="form-control" v-model="lodging">
                </input-prefix>
            </div>
        </div>

        <div class="per-diem__row">
            <div class="per-diem__heading">Meals &amp; Incidentals</div>

            <slot name="meals"></slot>

            <div class="per-diem__inputs">
                <label for="per-diem-meals_days" class="per-diem__label">Meal Days</label>
                <input type="text" id="per-diem-meals_days" name="days" class="form-control" v-model="days">

                <label for="per-diem-meals_pd" class="per-diem__label mt-3">US GSA Per Diem</label>
                <input-prefix prefix="$">
                    <input type="text" id="per-diem-meals_pd" name="meals_pd" class="form-control" v-model="mealsPd">
                </input-prefix>

                <label class="per-diem__label mt-3">Meals Total</label>
                <div class="per-diem__calculated">{{ mealsTotal }}</div>
                <input type="hidden" name="meals" v-model="mealsTotal">
                <div v-if="mealsTotal" class="per-diem__help">
                    ${{ mealsPd }} &times; {{ days }} days
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import dollarFormat from "../utilities/dollar-format";
    import InputPrefix from "../components/InputPrefix";
    import PerdiemStore from "./perdiem-store";
    export default {
        props: ['stateUri'],
        data() {
            return {
                store: new PerdiemStore(this.stateUri),
                days: null,
                nights: null,
                mealsPd: null,
                lodgingPd: null,
                lodging: null
            };
        },
        watch: {
            loaded(val) {
                if (val) {
                    this.days = this.store.days;
                    this.nights = this.store.nights;
                    this.mealsPd = this.store.mealsPd;
                    this.lodgingPd = this.store.lodgingPd;
                    this.lodging = this.store.lodging;
                }
            }
        },
        computed: {
            loaded() {
                return this.store.loaded;
            },
            mealsTotal() {
                if (this.days && this.mealsPd) {
                    return dollarFormat(this.days * this.mealsPd);
                }
                return '';
            },
            lodgingLimit() {
                if (this.nights && this.lodgingPd) {
                    return dollarFormat(this.nights * this.lodgingPd);
                }
                return '';
            },
            nightsPeriod() {
                if (!this.nights) {
                    return 'the entire trip';
                }
                if (this.nights == 1) {
                    return '1 night';
                }
                return this.nights + ' nights';
            }
        },
        components: {
            InputPrefix
        }
    }
</script>
