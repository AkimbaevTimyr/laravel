import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import EditPostForm from "@/Pages/Posts/Partials/EditPostForm.jsx";
import {useState} from "react";
export default function  PostPage ({auth, posts}) {
    const {id, title, is_visible} = posts;
    const { processing, errors, delete: destroy, post} = useForm({})
    const [isVisible, setIsVisible] = useState(is_visible == 1 ? true : false)
    const onDelete = (e) => {
        e.preventDefault();
        destroy(`/post-destroy/${id}`,  {
            preserveScroll: true,
        })
    }

    const setVisible = (e) => {
        e.preventDefault();
        setIsVisible(!isVisible);
        post(`/set-visible/${id}`, {
            preserveScroll: true
        })
    }

    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{title}</h2>}
        >
            <Head title={title} />

            <div className="py-12 p-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <EditPostForm
                            className="max-w-xl"
                            post={posts}
                        />
                        <div className="flex items-center  pl-6 pb-6">
                            <PrimaryButton onClick={(e)=> onDelete(e) } disabled={processing}>Delete</PrimaryButton>
                        </div>
                        <div className="flex items-center  pl-6 pb-6">
                            <PrimaryButton onClick={(e)=> setVisible(e)} >
                                {isVisible ? 'Hide Post' : 'Show Post'}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    )
}
