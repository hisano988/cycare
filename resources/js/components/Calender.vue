<template>
        <div>
            <table class="table table-bordered">
                <tr>
                    <td class="col-sun">日</td>
                    <td>月</td>
                    <td>火</td>
                    <td>水</td>
                    <td>木</td>
                    <td>金</td>
                    <td class="col-sat">土</td>
                </tr>
                <template v-for="week in getDates()">
                    <tr>
                        <td v-for="date in week">
                            <div class="d-flex flex-column">
                                <div :class="getDateClass(date)">{{ date.getDate() }}</div>
                                <!-- <div>@if($date->isSameDay($nextDay)) ● @endif</div> -->
                            </div>
                        </td>
                    </tr>
                </template>
            </table>
        </div>
</template>


<script lang="ts">
export default {
  props: {
  },
  data() {
    return {
        today: new Date(),
    }
  },
  methods: {
    getDates(): Date[][] {
        const nowYear = this.today.getFullYear();
        const nowMonth = this.today.getMonth();
        const startOfMonth = new Date(nowYear, nowMonth, 1);
        const endOfMonth = new Date(nowYear, nowMonth + 1, 0);

        // カレンダー表示の初日
        const subCntToSunday = startOfMonth.getDay();
        const startDate = new Date(startOfMonth.getFullYear(), startOfMonth.getMonth(), startOfMonth.getDate() - subCntToSunday);

        // カレンダー表示の終日
        const addCntToSaturday = 6 - endOfMonth.getDay();
        const endDate = new Date(endOfMonth.getFullYear(), endOfMonth.getMonth(), endOfMonth.getDate() + addCntToSaturday);

        // 1週間ごとに切り分けてDateの配列を生成
        const dates = [];
        let week = [];
        for(let date=startDate; date <= endDate; date.setDate(date.getDate() + 1)) {
            week.push(new Date(date.getTime()));

            if (week.length === 7) {
                dates.push(week);
                week = [];
            }
        }

        return dates;
    },
    isSunday(date: Date): boolean {
        return date.getDay() === 0;
    },
    isSturday(date: Date): boolean {
        return date.getDay() === 6;
    },
    getDateClass(date: Date): string {
        if (date.getMonth() !== this.today.getMonth()) {
            return "col-outed";
        }
        if (date.getDate() === this.today.getDate()) {
            return "font-weight-bold col-today";
        }
        if (this.isSunday(date)) {
            return "col-sun";
        }
        if (this.isSturday(date)) {
            return "col-sat"
        }
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
