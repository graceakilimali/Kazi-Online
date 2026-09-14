import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

export function useHomeSearch() {
    const keyword = ref<string>('');
    const departmentId = ref<string | number>('');

    const handleSearch = () => {
        const queryParams: Record<string, string | number> = {};
        if (keyword.value.trim()) {
            queryParams.search = keyword.value.trim();
        }
        if (departmentId.value) {
            queryParams.department_id = departmentId.value;
        }

        router.get('/jobs', queryParams, {
            preserveState: true,
        });
    };

    const selectDepartment = (id: number) => {
        departmentId.value = id;
        handleSearch();
    };

    return {
        keyword,
        departmentId,
        handleSearch,
        selectDepartment,
    };
}
