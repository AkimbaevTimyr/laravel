import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import {Link, useForm, usePage} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {Transition} from "@headlessui/react";

export default function EditPostForm({className, post}){

    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        title: post.title,
        description: post.description,
        // file: null
    });

    const submit = (e) => {
        e.preventDefault();
        patch(`/post-update/${post.id}`, {
            data: {
                title: data.title,
                description: data.description,
                // file: data.file
            },
        });
    };

    const onDelete = (e) => {
        e.preventDefault();
        destroy(`/post-destroy/${id}`,  {
            preserveScroll: true,
        })
    }
    return(
        <section className={className + ' p-6'}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Post Information</h2>

                <p className="mt-1 text-sm text-gray-600">
                    Update your post information.
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="title" value="Title" />

                    <TextInput
                        id="title"
                        className="mt-1 block w-full"
                        value={data.title}
                        onChange={(e) => setData('title', e.target.value)}
                        required
                        isFocused
                        autoComplete="title"
                    />

                    <InputError className="mt-2" message={errors.title} />
                </div>

                <div>
                    <InputLabel htmlFor="description" value="Description" />

                    <TextInput
                        id="description"
                        className="mt-1 block w-full"
                        value={data.description}
                        onChange={(e) => setData('description', e.target.value)}
                        required
                        autoComplete="description"
                    />

                    <InputError className="mt-2" message={errors.description} />
                </div>

                {/*<div>*/}
                {/*    <TextInput*/}
                {/*        id="media"*/}
                {/*        className="mt-1 block w-full"*/}
                {/*        type="file"*/}
                {/*        autoComplete="file"*/}
                {/*        onChange={(e) => setData('file', e.target.files[0])}*/}
                {/*    />*/}
                {/*</div>*/}

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

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
        </section>
    )
}
