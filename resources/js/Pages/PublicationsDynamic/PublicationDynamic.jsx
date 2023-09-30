import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Filler,
    Legend,
} from 'chart.js';
import {Line, getDatasetAtEvent, getElementAtEvent} from 'react-chartjs-2';
import {useRef} from "react";
import {useForm,} from "@inertiajs/react";


ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Filler,
    Legend
);


export const options = {
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Динамика публикаций',
        },
    },
};


export default function PublicationDynamic ({auth, posts}) {

    let postCount = 0;

    posts.map(item => postCount += item.post_count)

    const { post, get } = useForm();

    const labels = [];

    posts.map((el) => labels.push(el.post_date))

    const data = {
        labels,
        datasets: [
            {
                fill: false,
                label: `Количество Публикаций: ${postCount}`,
                data: posts.map((item) => item.post_count),
                borderColor: 'rgb(53, 162, 235)',
                backgroundColor: 'rgba(53, 162, 235, 0.5)',
            },
        ],
    };

    const lineRef = useRef();

    const printElementAtEvent = (element) => {
        if (!element.length) return;
        const { datasetIndex, index } = element[0];
        return data.labels[index];
    };

    const onClick = async (event) => {
        const {current: chart} = lineRef;
        const date = printElementAtEvent(getElementAtEvent(chart, event));
        console.log(date)
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Publications Dynamic</h2>}
        >
            <div className="py-14">
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6 text-gray-900">
                                <Line
                                    options={options}
                                    data={data}
                                    ref={lineRef}
                                    onClick={onClick}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}


