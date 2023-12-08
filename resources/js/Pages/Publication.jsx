import { Head, useForm } from "@inertiajs/react";
import TextInput from "@/Components/TextInput.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import { Transition } from "@headlessui/react";
import Comment from "@/Components/Comment";
import Pagination from '@/Components/Pagination';

export default function Publication({ auth, posts, comments }) {
    const { title, description, author, id } = posts;
    const { errors, processing, recentlySuccessful, data, post, setData, delete: destroy } = useForm({
        name: "",
        comment: ""
    });

    const submit = (e) => {
        e.preventDefault();
        post(`/create-comment/${id}`);
    }

    const handleDelete = (id) => {
        destroy(`/delete-comment/${id}`);
    }

    return (
        <div
            className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <Head title="Publication Page" />
            <div className="flex w-full">
                <div className="w-1/4 sm:px-6 lg:px-8 mb-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 className="p-6 text-lg font-medium text-gray-900">
                            {title}
                        </h2>
                        <div className="p-6 text-gray-900">{description}</div>
                        <div className="p-6 flex items-center gap-4">
                            <p className="mt-1 text-sm text-gray-600">
                                Author: {author}
                            </p>
                        </div>
                    </div>


                    <form onSubmit={submit} className="mt-6 space-y-6 bg-white p-5">
                        <div>
                            <InputLabel htmlFor="name" value="Имя" />

                            <TextInput
                                id="name"
                                className="mt-1 block w-full"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                                isFocused
                                autoComplete="name"
                            />

                            <InputError className="mt-2" message={errors.name} />
                        </div>

                        <div>
                            <InputLabel htmlFor="description" value="Комментарий" />

                            <TextInput
                                id="comment"
                                className="mt-1 block w-full"
                                value={data.comment}
                                onChange={(e) => setData('comment', e.target.value)}
                                required
                                autoComplete="comment"
                            />

                            <InputError className="mt-2" message={errors.comment} />
                        </div>


                        <div className="flex items-center gap-4">
                            <PrimaryButton disabled={processing}>Добавить</PrimaryButton>

                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <p className="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
                <div className="w-3/4 bg-white p-5">
                    {
                        comments.data.length ? (comments.data.map((comment) => (
                            <Comment key={comment.id} comment={comment} handleDelete={handleDelete} />                        
                        ))) : 'Комментарии не найдены! Оставьте первый комментарий'
                    }
                    {
                        comments.data.length ? ( <Pagination links={comments.links} />) : ''
                    }
                </div>
            </div>
        </div>
    )
}
