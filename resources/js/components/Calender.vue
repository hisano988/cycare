<template>
        <div>
            <div  class="d-flex justify-content-center">
                <button @click="previous()"><</button>
                <span>{{ yearMonth }}</span>
                <button @click="next()">></button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td class="col-sun">日</td>
                        <td>月</td>
                        <td>火</td>
                        <td>水</td>
                        <td>木</td>
                        <td>金</td>
                        <td class="col-sat">土</td>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="week in dates">
                        <tr>
                            <td v-for="date in week">
                                <div class="d-flex flex-column">
                                    <div :class="getDateClass(date)">{{ date.getDate() }}</div>
                                    <div v-if="isRecorded(date)">●</div>
                                    <div v-if="isPredicted(date)">○</div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
</template>


<script lang="ts">
export default {
  props: {
    defaultYearMonth: {
        type: String, // Y-m
        required: true,
    },
    records: {
        type: Array,
        default: () => [],
        required: false,
    },
    interval: {
        type: Number,
        default: null,
        required: false,
    }
  },
  data() {
    this.records.sort((a, b) => a.startDate - b.startDate);
    const latestRecord = this.records[this.records.length - 1];
    const startDateOflatestRecord = latestRecord ? new Date(latestRecord.startDate) : null;
    if (startDateOflatestRecord !== null) {
        startDateOflatestRecord.setHours(0, 0, 0, 0);
    }

    return {
        today: new Date(),
        yearMonth: this.$props.defaultYearMonth,
        startDateOflatestRecord: startDateOflatestRecord,
        year: 0,
        monthIdx: 0,
        dates: [],
        filteredRecords: [],
    }
  },
  watch: {
    yearMonth: {
      handler(val) {
        const yearMonth = val.split('-');
        this.year = parseInt(yearMonth[0]);
        this.monthIdx = parseInt(yearMonth[1]) - 1;
        this.dates = this.getDates();
        this.filteredRecords = this.getFilteredRecords();
      },
      immediate: true
    }
  },
  methods: {
    getDates(): Date[][] {
        const startOfMonth = new Date(this.year, this.monthIdx, 1);
        const endOfMonth = new Date(this.year, this.monthIdx + 1, 0);

        // カレンダー表示の初日
        const subCntToSunday = startOfMonth.getDay();
        const startDate = new Date(startOfMonth.getFullYear(), startOfMonth.getMonth(), startOfMonth.getDate() - subCntToSunday);

        // カレンダー表示の終日
        const addCntToSaturday = 6 - endOfMonth.getDay();
        const endDate = new Date(endOfMonth.getFullYear(), endOfMonth.getMonth(), endOfMonth.getDate() + addCntToSaturday);

        // 1週間ごとに切り分けてDateの配列を生成
        const dates: Date[][] = [];
        let week: Date[] = [];
        for(let date=startDate; date <= endDate; date.setDate(date.getDate() + 1)) {
            week.push(new Date(date.getTime()));

            if (week.length === 7) {
                dates.push(week);
                week = [];
            }
        }

        return dates;
    },
    getFilteredRecords() {
        const startOfMonth = new Date(this.year, this.monthIdx, 1);
        const endOfMonth = new Date(this.year, this.monthIdx + 1, 0);

        return this.records
            .map((record) => {
                // UTCとして解釈され+9hされてしまうため時間は0固定しておく
                const startDateUTC = new Date(record.startDate);
                const endDateUTC = record.endDate ? new Date(record.endDate) : new Date(record.startDate);
                startDateUTC.setHours(0, 0, 0, 0);
                endDateUTC.setHours(0, 0, 0, 0);

                return {
                    startDate: startDateUTC,
                    endDate: endDateUTC,
                }
            })
            // 表示月と期間が重複しているもののみ抽出
            .filter((record) => startOfMonth.getTime() <= record.endDate.getTime() && endOfMonth.getTime() >= record.startDate.getTime());
    },
    isSunday(date: Date): boolean {
        return date.getDay() === 0;
    },
    isSturday(date: Date): boolean {
        return date.getDay() === 6;
    },
    getDateClass(date: Date): string {
        if (! (date.getFullYear() === this.year && date.getMonth() === this.monthIdx)) {
            return "col-outed";
        }
        if (date.toDateString() === this.today.toDateString()) {
            return "font-weight-bold col-today";
        }
        if (this.isSunday(date)) {
            return "col-sun";
        }
        if (this.isSturday(date)) {
            return "col-sat"
        }

        return '';
    },
    isRecorded(date: Date): boolean {
        const time = date.getTime();
        // 未来
        if (date.getTime() >= this.today.getTime()) {
            return false;
        }
        return this.filteredRecords.some((record) => time >= record.startDate.getTime() && time <= record.endDate.getTime());
    },
    isPredicted(date: Date): boolean {
        // 記録が1つも無い
        if (this.startDateOflatestRecord === null) {
            return false;
        }
        // 過去
        if (date.getTime() < this.today.getTime()) {
            return false;
        }
        return this.diffDays(date, this.startDateOflatestRecord) % this.interval === 0;
    },
    next() {
        const yearMonthDate = new Date(this.yearMonth);
        yearMonthDate.setMonth(yearMonthDate.getMonth() + 1);
        this.yearMonth = yearMonthDate.getFullYear() + '-' + (yearMonthDate.getMonth() + 1);
    },
    previous() {
        const yearMonthDate = new Date(this.yearMonth);
        yearMonthDate.setMonth(yearMonthDate.getMonth() - 1);
        this.yearMonth = yearMonthDate.getFullYear() + '-' + (yearMonthDate.getMonth() + 1);
    },
    diffDays(day2: Date, day1: Date): number {
        // 1日 = 86,400,000ミリ秒
        return (day2.getTime() - day1.getTime()) / 86400000;
    }
  },
}
</script>
<style scoped>
    /* TODO: 移動 */
    .col-today {
        color:green !important;
    }
    .col-sun {
        color:red !important;
    }
    .col-sat {
        color:blue !important;
    }
    .col-outed {
        color:gray !important;
    }
</style>
