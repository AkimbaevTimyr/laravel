import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ImageComponent from "@/Components/ImageComponent.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useForm} from "@inertiajs/react";

export default function Media({auth, media}){
    const {get} = useForm()
    const downloadFile = (file) => {
        get(`/media-download/${file}`);
    }
    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <div className="flex flex-wrap items-center justify-center">
                {media.length == 0 ? 'Media не найдены' : media.map((file) => (
                    <div className="py-14" key={file.id}>
                        <div className="max-w-2xl mx-auto sm:px-6 lg:px-8">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900 flex flex-col">
                                    <ImageComponent imagePath={file.path} />
                                    <a href={`/media-download/${file.path}`} className="flex justify-center" >
                                        <PrimaryButton  className="mt-3 flex justify-center">Download</PrimaryButton>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </AuthenticatedLayout>
    )
}
