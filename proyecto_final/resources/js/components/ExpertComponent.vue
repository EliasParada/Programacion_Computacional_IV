<template>
    <!-- A form for aplication to add a new expert, it needs the next data:
        - natioality: string
        - dni: string
        - university: string
        - title: string -->
    <!-- Use tailwindcss to style the form -->
    <div class="grid gap-4 w-1/2 mx-auto bg-second-50 rounded-lg shadow-lg">
        <div class="flex flex-wrap justify-center pb-4">
                <form method="post" class="w-full max-w-sm bg-second-50 p-4 rounded-lg">
                    <!-- <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="grid-first-name">Correo</label>
                    <input class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" id="grid-first-name" autofocus type="email" value="{{ old('email') }}" placeholder="Jane@gmail.com" name="email" required>
                    @error('email')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror -->
                    <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="grid-first-name">Nacionalidad</label>
                    <!-- Un select para las nacionalidades -->
                    <select class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" id="grid-first-name" v-model="expert.nationality" required>
                        <option value="">Seleccione una nacionalidad</option>
                        <option v-for="country in countries" :key="country" value="country">country</option>
                    </select>
                    <span class="text-red-500 text-center" v-if="errors.nationality">
                        {{ error.nationality }}
                    </span>
                    <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="grid-first-name">Número de Identificación</label>
                    <!-- Use a patter from dnis[nat] to validate the dni -->
                    <input type="text" class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" id="grid-first-name" v-model="expert.dni" placeholder="12345678" required pattern="dnis[expert.nationality]">
                    
    </div>

</template>

<script>
export default defineComponent({
    data() {
        return {
            countries: [
                'Canada',
                'El Salvador',
                'Mexico',
                'United States',
            ],
            dnis: {
                'Canada': [
                    '\d{2}\.\d{3}\.\d{3}'
                ],
                'El Salvador': [
                    '^\d{8}-\d{1}$'
                ],
                'Mexico': [
                    '[AZ] {6} [0-9] {8} [AZ] {1} [0-9] {3}'
                ],
                'United States': [
                    '^ \ d {3} \ - \ d {2} - \ d {4} $'
                ],
            },
            },
            expert: {
                nationality: '',
            }
        }
    }
})
</script>
