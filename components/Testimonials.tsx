'use client'

import { motion } from 'framer-motion'
import { Star, Quote } from 'lucide-react'

const testimonials = [
  {
    name: 'Zaheer Allana',
    company: 'Bin Qasim (Pvt) Ltd.',
    content: 'eTax consultants always offers effective solutions to complex legal issues. Their forte is their speed and swift response. We believe that they are the finest lawyers a litigant can find in our legal system.',
    rating: 5
  },
  {
    name: 'Awan Trading (Pvt) Ltd.',
    company: 'Leading Import House',
    content: 'Mr. Amjad Javaid Hashmi and his associates represented us recently in a constitutional petition. He vociferously argued and the honorable High Court was pleased to restrain the tax authorities.',
    rating: 5
  },
  {
    name: 'Airwaves Media (Pvt) Ltd.',
    company: 'Interflow Group',
    content: 'Mr. Hashmi and his team stand out among them as they work hard on their brief and have a very professional approach to their work. Leading names of the legal fraternity have represented us.',
    rating: 5
  },
  {
    name: 'Basharat Ullah Khan',
    company: 'PSX Stockbrokers Association',
    content: 'In our two years experience with Tax Pulse, we have found the team to be very thorough in approach, deep in appreciation of facts and candid in legal opinion.',
    rating: 5
  },
  {
    name: 'Muneer Ahmed Memon',
    company: 'CEO – Voices (Pvt) Ltd.',
    content: 'Since my association with Tax Pulse, I am much more confident to focus all my attention on the expansion of my business. I believe in the professionalism of Mr. Hashmi and his team.',
    rating: 5
  },
  {
    name: 'Ahmad Raza Khan',
    company: 'CEO – ECOMS',
    content: 'I was truly impressed by their unparalleled level of expertise and professionalism. His great knowledge, command and clarity over TAX Laws are inconceivable and great learning for me always.',
    rating: 5
  }
]

export default function Testimonials() {
  return (
    <section className="section-padding bg-white">
      <div className="container-custom">
        <motion.div 
          className="text-center mb-16"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
        >
          <h2 className="text-4xl md:text-5xl font-bold mb-6">
            What Our <span className="gradient-text">Clients Say</span>
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Don't just take our word for it. Here's what our valued clients across Pakistan have to say about our services.
          </p>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {testimonials.map((testimonial, index) => (
            <motion.div
              key={testimonial.name}
              className="card p-6 relative"
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
              whileHover={{ y: -8 }}
            >
              <Quote className="absolute top-4 right-4 w-8 h-8 text-primary-200" />
              
              <div className="flex mb-4">
                {[...Array(testimonial.rating)].map((_, i) => (
                  <Star key={i} className="w-5 h-5 text-accent-500 fill-current" />
                ))}
              </div>
              
              <blockquote className="text-gray-600 mb-6 leading-relaxed italic">
                "{testimonial.content}"
              </blockquote>
              
              <div className="border-t pt-4">
                <div className="font-semibold text-gray-900">{testimonial.name}</div>
                <div className="text-sm text-gray-500">{testimonial.company}</div>
              </div>
            </motion.div>
          ))}
        </div>

        <motion.div 
          className="text-center mt-16"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8, delay: 0.4 }}
        >
          <p className="text-lg text-gray-600 mb-6">
            Join thousands of satisfied clients who trust eTax consultants with their tax matters.
          </p>
          <a href="/contact" className="btn-primary">
            Get Started Today
          </a>
        </motion.div>
      </div>
    </section>
  )
}
